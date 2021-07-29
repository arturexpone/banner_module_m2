<?php

namespace M2task\BannerManagement\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class BannerStore extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('banner_store_link', 'link_id');
    }
}
