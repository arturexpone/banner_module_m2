<?php

namespace M2task\BannerGraphQl\Controller\Adminhtml\Settings;

use M2task\BannerGraphQl\Controller\Adminhtml\BannerIndex;
use M2task\BannerGraphQl\Model\Banner;
use M2task\BannerGraphQl\Model\BannerFactory;
use M2task\BannerGraphQl\Model\ResourceModel\BannerResource;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\PageFactory;

class Edit extends BannerIndex
{
    /**
     * @var BannerFactory
     */
    private $bannerFactory;
    /**
     * @var BannerResource
     */
    private $bannerResource;

    /**
     * Edit constructor.
     * @param PageFactory $pageFactory
     * @param ForwardFactory $forwardFactory
     * @param Action\Context $context
     */
    public function __construct(
        PageFactory $pageFactory,
        ForwardFactory $forwardFactory,
        BannerFactory $bannerFactory,
        BannerResource $bannerResource,
        Action\Context $context
    ) {
        parent::__construct($pageFactory, $forwardFactory, $context);
        $this->bannerFactory = $bannerFactory;
        $this->bannerResource = $bannerResource;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var Banner $model */
        $model = $this->bannerFactory->create();

        if ($id) {
            $this->bannerResource->load($model, $id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Banner not found'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $resultPage = $this->__initPage();
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getBannerName() : __('New Banner'));

        return $resultPage;
    }
}
