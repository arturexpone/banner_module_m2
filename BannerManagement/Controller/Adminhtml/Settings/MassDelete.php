<?php

namespace M2task\BannerManagement\Controller\Adminhtml\Settings;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var \M2task\BannerManagement\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * MassDelete constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \M2task\BannerManagement\Model\ResourceModel\Banner\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \M2task\BannerManagement\Model\ResourceModel\Banner\CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $label) {
            $label->delete();
        }

        $this->messageManager->addSuccessMessage(__('A total of ' . $collectionSize . ' record(s) have been deleted.'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
