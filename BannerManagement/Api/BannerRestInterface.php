<?php


namespace M2task\BannerManagement\Api;

/**
 * @api
 */

interface BannerRestInterface
{
    /**
     *
     * @api
     * @param string $viewed_banners
     * @param string $banners_group
     * @param string $storeIds
     * @return string
     */
    public function getRandomBanner($banners_group, $storeIds, $viewed_banners);
}
