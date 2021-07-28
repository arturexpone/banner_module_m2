<?php

namespace M2task\BannerManagement\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Store\Model\StoreManagerInterface as StoreManager;

class Banners extends Template implements BlockInterface
{
    const GROUP_CODE = 'banner_group_code';

    protected $_template = "widget/banner.phtml";

    /**
     * @var StoreManager
     */
    private $storeManager;

    public function __construct(
        Template\Context $context,
        array $data = [],
        StoreManager $storeManager
    )
    {
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
    }

    /**
     * @return array|mixed|string
     */
    public function getGroupCode() {
        return $this->getData(self::GROUP_CODE) ?? '0';
    }

    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return string|array
     */
    public function getStoreId() {
        return $this->storeManager->getStore()->getId();
    }
}
