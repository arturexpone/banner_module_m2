<?php


namespace M2task\BannerManagement\Api;

/**
 * @api
 */

interface GetRandomBannerInterface
{
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $viewed_banners
     * @param string $banners_group
     * @return string
     */
    public function exec($banners_group, $viewed_banners);
}
