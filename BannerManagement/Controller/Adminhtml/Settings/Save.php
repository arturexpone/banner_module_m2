<?php


namespace M2task\BannerManagement\Controller\Adminhtml\Settings;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;

use M2task\BannerManagement\Model\ImageUploader;

class Save extends \M2task\BannerManagement\Controller\Adminhtml\BannerIndex
{
    /**
     * @var \M2task\BannerManagement\Model\BannerFactory
     */
    protected $bannerFactory;
    private $imageUploader;

    /**
     * Save constructor.
     * @param \M2task\BannerManagement\Model\BannerFactory $bannerFactory
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
     * @param Action\Context $context
     */
    public function __construct(
        \M2task\BannerManagement\Model\BannerFactory $bannerFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory,
        ImageUploader $imageUploader,
        Action\Context $context
    )
    {
        $this->bannerFactory = $bannerFactory;
        $this->imageUploader = $imageUploader;
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
            $model = $this->bannerFactory->create();
            $id = $this->getRequest()->getParam('banner_id');

            if ($id) {
                try {
                    $model = $model->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This banner no longer exists'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $data = $this->filterFoodData($data);

            $model->setName($data['banner_name'])
                ->setBannerContent($data['banner_text_content'])
                ->setBannerPopupContent($data['banner_popup_text_content'])
                ->setShowStartDate($data['show_start_date'])
                ->setShowEndDate($data['show_end_date'])
                ->setShowOnce($data['show_once'])
                ->setGroupCode($data['group_code'])
                ->setDesktopImage($data['desktop_image'])
                ->setMobileImage($data['mobile_image']);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the banner'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Some thing went wrong while saving the banner'));
            }
            return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function filterFoodData($data)
    {
        $devices = ['desktop', 'mobile'];
        foreach ($devices as $device) {
            if (isset($data[$device . '_image'][0]['name'])) {
                $data[$device . '_image'] = $data[$device . '_image'][0]['name'];
            }
        }

        return $data;
    }
}
