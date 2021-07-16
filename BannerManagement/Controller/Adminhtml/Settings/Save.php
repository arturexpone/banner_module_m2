<?php


namespace M2task\BannerManagement\Controller\Adminhtml\Settings;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;

class Save extends \M2task\BannerManagement\Controller\Adminhtml\BannerIndex
{
    /**
     * @var \M2task\BannerManagement\Model\BannerFactory
     */
    protected $bannerFactory;

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
        Action\Context $context
    )
    {
        $this->bannerFactory = $bannerFactory;
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

            $model->setName($data['banner_name'])
                ->setBannerContent($data['banner_text_content'])
                ->setBannerPopupContent($data['banner_popup_text_content'])
                ->setShowStartDate($data['show_start_date'])
                ->setShowEndDate($data['show_end_date'])
                ->setShowOnce($data['show_once']);

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
}
