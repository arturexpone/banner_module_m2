<?php

namespace M2task\BannerManagement\Block\Widget;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

use M2task\BannerManagement\Api\BannerRepositoryInterface;

class Banners extends Template implements BlockInterface
{
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
     * @var mixed|string
     */
    private $_viewedBanners;

    private $randomBanner;

    public function __construct(
        Template\Context $context,
        array $data = [],
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Filter $filter
    )
    {
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filter = $filter;
        $this->_viewedBanners = $_COOKIE['viewedBanners'] ?? '0';

        parent::__construct($context, $data);
    }

    /**
     * @return array|mixed|string
     */
    public function getGroupCode() {
        return $this->getData('banner_group_code') ?? '';
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
     * @param $banner
     * @return $this
     */
    public function setShowOnceBannerToCoockie($banner) {
        if ($banner['show_once'] === '1') {
            setcookie('viewedBanners', $this->_viewedBanners . "," . $banner['banner_id']);
        };
        return $this;
    }

    /**
     * @return $this
     */
    public function setRandomBanner() {
        if (!isset($this->randomBanner)) {
            try {
                $currentDate = date('Y.m.d');
                $bannerGroup = $this->getGroupCode();
                $filter = $this->filter->setField('rand');

                $this->searchCriteriaBuilder
                    ->addFilter('group_code', $bannerGroup)
                    ->addFilter('banner_id', $this->_viewedBanners, 'nin')
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

                return $this;
            } catch (\Exception $exception) {
                throw new \Error($exception->getMessage());
                // ...
            }
        }
        return $this;
    }


}
