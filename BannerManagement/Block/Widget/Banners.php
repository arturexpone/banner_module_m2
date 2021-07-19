<?php

namespace M2task\BannerManagement\Block\Widget;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

use M2task\BannerManagement\Api\BannerRepositoryInterface;

class Banners extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "widget/banner.phtml";
}
