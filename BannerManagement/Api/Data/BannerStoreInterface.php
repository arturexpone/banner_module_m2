<?php


namespace M2task\BannerManagement\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface BannerStoreInterface extends ExtensibleDataInterface
{
    const LINK_ID = 'link_id';
    const BANNER_ID = 'banner_id';
    const STORE_ID = 'store_id';

    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getBannerId();

    /**
     * @return string
     */
    public function getStoreId();

    /**
     * @param string $id
     * @return \M2task\BannerManagement\Model\BannerStore
     */
    public function setId(string $id);

    /**
     * @param string $id
     * @return \M2task\BannerManagement\Model\BannerStore
     */
    public function setBannerId(string $id);

    /**
     * @param string
     * @return \M2task\BannerManagement\Model\BannerStore
     */
    public function setStoreId(string $id);

}
