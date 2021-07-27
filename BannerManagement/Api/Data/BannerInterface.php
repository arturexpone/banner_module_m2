<?php

namespace M2task\BannerManagement\Api\Data;
use M2task\BannerManagement\Model\Banner;
use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * CMS block interface.
 * @api
 * @since 100.0.2
 */

interface BannerInterface extends ExtensibleDataInterface
{
    const ENTITY_ID = 'banner_id';
    const NAME = 'banner_name';
    const BANNER_CONTENT = 'banner_text_content';
    const BANNER_POPUP_CONTENT = 'banner_popup_text_content';
    const SHOW_ONCE = 'show_once';
    const SHOW_START_DATE = 'show_start_date';
    const SHOW_END_DATE = 'show_end_date';
    const GROUP_CODE = 'group_code';
    const DESKTOP_IMAGE = 'desktop_image';
    const MOBILE_IMAGE = 'mobile_image';
    const STORE_VIEWS = 'store_views';

    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getStoreViews();

    /**
     * @return string
     */
    public function getBannerName();

    /**
     * @return string
     */
    public function getShowStartDate();

    /**
     * @return string
     */
    public function getShowEndDate();

    /**
     * @return string
     */
    public function getGroupCode();

    /**
     * @param $id
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setId($id);

    /**
     * @param string $id
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setStoreViews(string $id);

    /**
     * @param string $name
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setBannerName(string $name);

    /**
     * @param string $text
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setBannerContent(string $text);

    /**
     * @param string $text
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setBannerPopupContent(string $text);

    /**
     * @param string $startDate
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setShowStartDate(string $startDate);

    /**
     * @param string $endDate
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setShowEndDate(string $endDate);

    /**
     * @param bool $toggle
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setShowOnce(bool $toggle);

    /**
     * @param string $code
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setGroupCode(string $code);

    /**
     * @param string $name
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setDesktopImage(string $name);

    /**
     * @param string $name
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setMobileImage(string $name);
}
