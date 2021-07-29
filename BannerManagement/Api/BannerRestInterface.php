<?php


namespace M2task\BannerManagement\Api;

/**
 * @api
 */

interface BannerRestInterface
{
    /**
     *
     * @param string $viewedBanners
     * @param string $bannersGroup
     * @param string $storeIds
     * @return string
     *@api
     */
    public function getRandomBanner($bannersGroup, $storeIds, $viewedBanners);

    /**
     * @return bool|mixed|string
     */
    public function getBanner();
}
