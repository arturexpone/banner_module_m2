<?php


namespace M2task\BannerManagement\Model\ResourceModel\Banner;


use Magento\Framework\DB\Select;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zend_Db_Expr;

class Collection extends AbstractCollection
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init(\M2task\BannerManagement\Model\Banner::class, \M2task\BannerManagement\Model\ResourceModel\BannerResource::class);
    }

    public function addStoreFilter($storeId)
    {

        $this->getSelect()->joinLeft(
            ['s' => $this->getTable('banner_store_link')],
            "s.banner_id = main_table.banner_id " . new Zend_Db_Expr("WHERE IF(s.store_id != $storeId, s.store_id IN($storeId), s.store_id IN(0))"),
            'store_id'
            )
            ->group(
            ['main_table.banner_id']
        );

        return $this;
    }
}
