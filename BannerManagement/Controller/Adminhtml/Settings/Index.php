<?php
namespace M2task\BannerManagement\Controller\Adminhtml\Settings;

use M2task\BannerManagement\Model\BannerFactory;
use M2task\BannerManagement\Model\ResourceModel\Banner\Collection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
class Index extends Action implements HttpGetActionInterface
{
    const MENU_ID = 'M2task_BannerManagement::bannermanagement';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var BannerFactory
     */
    private $bannerFactory;
    /**
     * @var \M2task\BannerManagement\Model\ResourceModel\BannerResource
     */
    private $bannerResource;
    /**
     * @var Collection
     */
    private $collection;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BannerFactory $bannerFactory,
        \M2task\BannerManagement\Model\ResourceModel\BannerResource $bannerResource,
        Collection $collection
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
        $this->bannerFactory = $bannerFactory;
        $this->bannerResource = $bannerResource;
        $this->collection = $collection;
    }

    /**
     * Load the page defined in view/adminhtml/layout/bannermanagement_settings_index.xml
     *
     * @return Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('Banner Management'));

        return $resultPage;
    }
}
