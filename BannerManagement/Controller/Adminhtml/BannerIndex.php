<?php


namespace M2task\BannerManagement\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class BannerIndex extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;


    /**
     * BannerIndex constructor.
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
     * @param Action\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory,
        Action\Context $context
    ) {
        $this->resultPageFactory = $pageFactory;
        $this->resultForwardFactory = $forwardFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function __initPage()
    {
        return $this->resultPageFactory->create();
    }
}
