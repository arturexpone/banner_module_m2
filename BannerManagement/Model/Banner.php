<?php

namespace M2task\BannerManagement\Model;

use Magento\Framework\Model\AbstractExtensibleModel;

use M2task\BannerManagement\Api\Data\BannerInterface;


class Banner extends AbstractExtensibleModel implements BannerInterface
{

    protected function _construct()
    {
        $this->_init(ResourceModel\BannerResource::class);
    }

    /**
     * @return string|null
     */
    public function getBannerName()
    {
        return parent::getData(self::NAME);
    }

    /**
     * @return string|null
     */
    public function getStoreViews() {
        return parent::getData(self::STORE_VIEWS);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return parent::getData(self::NAME);
    }


    /**
     * @return string
     */
    public function getShowEndDate() {
        return parent::getData(self::SHOW_END_DATE);
    }


    /**
     * @return string
     */
    public function getShowStartDate() {
        return parent::getData(self::SHOW_START_DATE);
    }

    /**
     * @return string
     */
    public function getGroupCode() {
        return parent::getData(self::GROUP_CODE);
    }

    /**
     * @param string $id
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * @param string $name
     * @return \M2task\BannerManagement\Model\Banner|null
     */
    public function setBannerName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @param string $text
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setBannerContent(string $text) {
        return $this->setData(self::BANNER_CONTENT, $text);
    }

    /**
     * @param string $text
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setBannerPopupContent(string $text) {
        return $this->setData(self::BANNER_POPUP_CONTENT, $text);
    }

    /**
     * @param string $id
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setStoreViews(string $id) {
        return $this->setData(self::STORE_VIEWS, $id);
    }

    /**
     * @param string|null $startDate
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setShowStartDate(string $startDate = null) {
        return $this->setData(self::SHOW_START_DATE, $startDate);
    }

    /**
     * @param string|null $endDate
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setShowEndDate(string $endDate = null) {
        return $this->setData(self::SHOW_END_DATE, $endDate);
    }

    /**
     * @param bool|null $toggle
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setShowOnce(bool $toggle = null) {
        return $this->setData(self::SHOW_ONCE, $toggle);
    }

    /**
     * @param string $code
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setGroupCode(string $code)
    {
        return $this->setData(self::GROUP_CODE, $code);
    }

    /**
     * @param string $name
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setDesktopImage(string $name)
    {
        return $this->setData(self::DESKTOP_IMAGE, $name);
    }

    /**
     * @param string $name
     * @return \M2task\BannerManagement\Model\Banner
     */
    public function setMobileImage(string $name)
    {
        return $this->setData(self::MOBILE_IMAGE, $name);
    }

}
