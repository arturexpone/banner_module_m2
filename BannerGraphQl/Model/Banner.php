<?php

namespace M2task\BannerGraphQl\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use M2task\BannerGraphQl\Api\Data\BannerInterface;

class Banner extends AbstractExtensibleModel implements BannerInterface
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\BannerResource::class);
    }

    /**
     * @return mixed|null
     */
    public function getBannerByName()
    {
        return parent::getData(self::NAME);
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * @return mixed|null
     */
    public function getName()
    {
        return parent::getData(self::NAME);
    }

    /**
     * @param mixed $id
     * @return Banner|mixed
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * @param string $name
     * @return Banner|mixed
     */
    public function setName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @param string $text
     * @return Banner|mixed
     */
    public function setBannerContent(string $text) {
        return $this->setData(self::BANNER_CONTENT, $text);
    }

    /**
     * @param string $text
     * @return Banner|mixed
     */
    public function setBannerPopupContent(string $text) {
        return $this->setData(self::BANNER_POPUP_CONTENT, $text);
    }

    /**
     * @param string|null $startDate
     * @return Banner|mixed
     */
    public function setShowStartDate(string $startDate = null) {
        return $this->setData(self::SHOW_START_DATE, $startDate);
    }

    /**
     * @param string|null $endDate
     * @return Banner|mixed
     */
    public function setShowEndDate(string $endDate = null) {
        return $this->setData(self::SHOW_END_DATE, $endDate);
    }

    /**
     * @param bool|null $toggle
     * @return Banner|mixed
     */
    public function setShowOnce(bool $toggle = null) {
        return $this->setData(self::SHOW_ONCE, $toggle);
    }

    /**
     * @param string $code
     * @return Banner|mixed
     */
    public function setGroupCode(string $code)
    {
        return $this->setData(self::GROUP_CODE, $code);
    }

    /**
     * @param string $name
     * @return Banner|mixed
     */
    public function setDesktopImage(string $name)
    {
        return $this->setData(self::DESKTOP_IMAGE, $name);
    }

    /**
     * @param string $name
     * @return Banner|mixed
     */
    public function setMobileImage(string $name)
    {
        return $this->setData(self::MOBILE_IMAGE, $name);
    }

}
