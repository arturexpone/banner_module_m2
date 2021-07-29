<?php

namespace M2task\BannerManagement\Controller\Adminhtml\Settings;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\ForwardFactory;

use M2task\BannerManagement\Api\BannerRepositoryInterface;
use M2task\BannerManagement\Model\BannerFactory;

class Save extends \M2task\BannerManagement\Controller\Adminhtml\BannerIndex
{

    const STORE_IDS = 'shown_store_id';
    /**
     * @var BannerFactory
     */
    protected $bannerFactory;
    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;

    /**
     * Save constructor.
     * @param BannerFactory $bannerFactory
     * @param PageFactory $pageFactory
     * @param ForwardFactory $forwardFactory
     * @param Context $context
     */
    public function __construct(
        PageFactory $pageFactory,
        ForwardFactory $forwardFactory,
        Context $context,
        BannerFactory $bannerFactory,
        BannerRepositoryInterface $bannerRepository
    )
    {
        $this->bannerFactory = $bannerFactory;
        $this->bannerRepository = $bannerRepository;

        parent::__construct($pageFactory, $forwardFactory, $context);
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {

            $id = $this->getRequest()->getParam('banner_id');

            try {
                $banner = $id ? $this->bannerRepository->getById($id) : $this->bannerFactory->create();
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists'));
                return $resultRedirect->setPath('*/*/');
            }

            $data = $this->filterImageData($data);
            $data = $this->filterStoreData($data);

            $banner->setName($data['banner_name'])
                ->setBannerContent($data['banner_text_content'])
                ->setBannerPopupContent($data['banner_popup_text_content'])
                ->setShowStartDate($data['show_start_date'])
                ->setShowEndDate($data['show_end_date'])
                ->setShowOnce($data['show_once'])
                ->setGroupCode($data['group_code'])
                ->setDesktopImage($data['desktop_image'])
                ->setMobileImage($data['mobile_image'])
                ->setShownStoreId($data[self::STORE_IDS]);

            try {
                $this->bannerRepository->save($banner);
                $this->messageManager->addSuccessMessage(__('You saved the banner'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Some thing went wrong while saving the banner'));
            }
            return $resultRedirect->setPath('*/*/edit', ['id' => $banner->getId()]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function filterImageData($data)
    {
        $devices = ['desktop', 'mobile'];
        foreach ($devices as $device) {
            if (isset($data[$device . '_image'][0]['name'])) {
                $data[$device . '_image'] = $data[$device . '_image'][0]['name'];
            }
        }

        return $data;
    }

    public function filterStoreData($data)
    {
        $storeIds = '';
        foreach ($data[self::STORE_IDS] as $i => $store) {
            $storeIds .=
                $i > 0 ? ',' . $store : $store;
        }

        $data[self::STORE_IDS] = implode(',', $data[self::STORE_IDS]);

        return $data;
    }
}
