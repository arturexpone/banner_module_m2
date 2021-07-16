<?php


namespace M2task\BannerManagement\Model\ResourceModel\Banner;


use Magento\Framework\DB\Select;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init(\M2task\BannerManagement\Model\Banner::class, \M2task\BannerManagement\Model\ResourceModel\BannerResource::class);
    }
}
