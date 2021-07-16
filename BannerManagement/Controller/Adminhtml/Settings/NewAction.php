<?php

namespace M2task\BannerManagement\Controller\Adminhtml\Settings;

class NewAction extends \M2task\BannerManagement\Controller\Adminhtml\BannerIndex
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
