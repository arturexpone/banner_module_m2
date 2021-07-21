<?php

namespace M2task\BannerManagement\Block\Widget;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;

use M2task\BannerManagement\Api\BannerRepositoryInterface;

class Banners extends Template implements BlockInterface
{
    const GROUP_CODE = 'banner_group_code';
    protected $_template = "widget/banner.phtml";

    /**
     * @return array|mixed|string
     */
    public function getGroupCode() {
        return $this->getData(self::GROUP_CODE) ?? '0';
    }
}
