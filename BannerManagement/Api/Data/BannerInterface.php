<?php

namespace M2task\BannerManagement\Api\Data;
use Magento\Framework\Api\ExtensibleDataInterface;

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

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getBannerByName();

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @param string $name
     * @return mixed
     */
    public function setName(string $name);

    /**
     * @param string $text
     * @return mixed
     */
    public function setBannerContent(string $text);

    /**
     * @param string $text
     * @return mixed
     */
    public function setBannerPopupContent(string $text);

    /**
     * @param string $startDate
     * @return mixed
     */
    public function setShowStartDate(string $startDate);

    /**
     * @param string $endDate
     * @return mixed
     */
    public function setShowEndDate(string $endDate);

    /**
     * @param bool $toggle
     * @return mixed
     */
    public function setShowOnce(bool $toggle);

    /**
     * @param string $code
     * @return mixed
     */
    public function setGroupCode(string $code);
}
