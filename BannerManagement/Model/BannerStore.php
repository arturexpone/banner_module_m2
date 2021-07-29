<?php

namespace M2task\BannerManagement\Model;

use Magento\Framework\Model\AbstractExtensibleModel;

use M2task\BannerManagement\Api\Data\BannerStoreInterface;

class BannerStore extends AbstractExtensibleModel implements BannerStoreInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\BannerStore::class);
    }

    /**
     * @return string
     */
    public function getId() {
        return parent::getData(self::LINK_ID);
    }

    /**
     * @return string
     */
    public function getBannerId() {
        return parent::getData(self::BANNER_ID);
    }

    /**
     * @return string
     */
    public function getStoreId() {
        return parent::getData(self::STORE_ID);
    }

    /**
     * @param string $id
     * @return \M2task\BannerManagement\Model\BannerStore
     */
    public function setId($id) {
        return parent::setData(self::LINK_ID, $id);
    }

    /**
     * @param string $id
     * @return \M2task\BannerManagement\Model\BannerStore
     */
    public function setBannerId(string $id) {
        return parent::setData(self::BANNER_ID, $id);
    }

    /**
     * @param string $id
     * @return \M2task\BannerManagement\Model\BannerStore
     */
    public function setStoreId(string $id) {
        return parent::setData(self::STORE_ID, $id);
    }
}
