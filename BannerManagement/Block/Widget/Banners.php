<?php

namespace M2task\BannerManagement\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

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
