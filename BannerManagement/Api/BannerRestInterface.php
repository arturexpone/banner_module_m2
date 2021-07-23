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
     * @return string
     */
    public function getRandomBanner($banners_group, $viewed_banners);
}
