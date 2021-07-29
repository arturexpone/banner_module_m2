<?php


namespace M2task\BannerManagement\Model\ResourceModel\BannerStore;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(\M2task\BannerManagement\Model\BannerStore::class, \M2task\BannerManagement\Model\ResourceModel\BannerStore::class);
    }

}
