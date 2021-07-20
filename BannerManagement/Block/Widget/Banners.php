<?php

namespace M2task\BannerManagement\Block\Widget;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;

use M2task\BannerManagement\Api\BannerRepositoryInterface;

class Banners extends Template implements BlockInterface
{
    const COOKIE_NAME = 'viewed_banners';
    const GROUP_CODE = 'banner_group_code';
    /**
     * @var string
     */
    protected $_template = "widget/banner.phtml";
    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var
     */
    private $randomBanner;

    /**
     * @var CookieManagerInterface
     */
    private $cookieManager;
    private $storeManager;

    public function __construct(
        Template\Context $context,
        array $data = [],
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CookieManagerInterface $cookieManager,
        StoreManagerInterface $storeManager,
        Filter $filter
    )
    {
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filter = $filter;
        $this->cookieManager = $cookieManager;
        $this->storeManager = $storeManager;

        parent::__construct($context, $data);
    }

    public function getCookie() {
        return $this->cookieManager->getCookie(self::COOKIE_NAME);
    }

    /**
     * @return array|mixed|string
     */
    public function getGroupCode() {
        return $this->getData(self::GROUP_CODE) ?? '';
    }

    /**
     * @return array|null
     */
    public function getRandomBanner() {
        if (!isset($this->randomBanner)) $this->setRandomBanner();
        return $this->randomBanner ?? null;
    }

    /**
     * @param $data
     * @return mixed|string|null
     */
    public function getBannerData($data) {
        if (!isset($this->randomBanner)) return null;
        return $this->randomBanner[$data] ?? '';
    }

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
                UrlInterface::URL_TYPE_MEDIA
            ) . 'banners/tmp/banner/';
    }

    /**
     * @param $banner
     * @return $this
     */
    public function setShowOnceBannerToCoockie($banner) {
        if ($banner['show_once'] === '1') {
            $this->cookieManager->setPublicCookie(
                self::COOKIE_NAME,
                $this->getCookie() . "," . $banner['banner_id']
            );
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function setRandomBanner() {
        if (!isset($this->randomBanner)) {
            $currentDate = date('Y.m.d');
            $bannerGroup = $this->getGroupCode();
            $filter = $this->filter->setField('rand');

            $this->searchCriteriaBuilder
                ->addFilter('group_code', $bannerGroup)
                ->addFilter('banner_id', $this->getCookie(), 'nin')
                ->addFilter('show_start_date', $currentDate, 'lteq')
                ->addFilter('show_end_date', $currentDate, 'gteq');
            $this->searchCriteriaBuilder->addFilters([$filter]);

            $searchCriteria = $this->searchCriteriaBuilder->create();
            $banners = $this->bannerRepository->getList($searchCriteria)->getItems();

            if (count($banners) > 0) {
                $randomBanner = $banners[array_key_first($banners)]->getData();
                $this->setShowOnceBannerToCoockie($randomBanner);
                $this->randomBanner = $randomBanner;
            }
        }
        return $this;
    }
}
