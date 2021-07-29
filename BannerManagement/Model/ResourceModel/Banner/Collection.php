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

    public function addStoreFilter($store)
    {
        $storeFilter = [$store];
        $this->getSelect()->joinLeft(
            ['s' => $this->getTable('banner_store_link')],
            "s.banner_id = main_table.banner_id",
            'store_id'
        )
            ->where(
            's.store_id IN (?)',
                $storeFilter)
            ->group(
            ['main_table.banner_id']
        );

        return $this;
    }
}
