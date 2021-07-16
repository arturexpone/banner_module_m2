<?php

namespace M2task\BannerManagement\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class BannerResource extends AbstractDb
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('banner', 'banner_id');
    }
}
