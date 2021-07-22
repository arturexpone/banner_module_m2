<?php

namespace M2task\BannerGraphQl\Controller\Adminhtml\Settings;

use M2task\BannerGraphQl\Controller\Adminhtml\BannerIndex;

class Delete extends BannerIndex
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->_objectManager->create(\M2task\BannerGraphQl\Model\Banner::class);
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the banner'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a banner to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
