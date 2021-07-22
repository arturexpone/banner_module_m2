<?php

namespace M2task\BannerGraphQl\Controller\Adminhtml\Settings;

class NewAction extends \M2task\BannerGraphQl\Controller\Adminhtml\BannerIndex
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
