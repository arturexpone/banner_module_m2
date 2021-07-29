<?php

namespace M2task\BannerManagement\Model\Rest;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Serialize\Serializer\Json;

use M2task\BannerManagement\Api\BannerRestInterface;
use M2task\BannerManagement\Api\BannerRepositoryInterface;

class Banner implements BannerRestInterface
{
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
     * @var DateTime
     */
    private $date;
    /**
     * @var Json
     */
    private $jsonSerializer;
    /**
     * @var FilterGroup
     */
    private $filterGroup;

    /**
     * GetRandomBanner constructor.
     * @param BannerRepositoryInterface $bannerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Filter $filter
     * @param FilterGroup $filterGroup
     * @param DateTime $date
     * @param Json $jsonSerializer
     */
    public function __construct(
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Filter $filter,
        FilterGroup $filterGroup,
        DateTime $date,
        Json $jsonSerializer
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filter = $filter;
        $this->date = $date;
        $this->jsonSerializer = $jsonSerializer;
        $this->filterGroup = $filterGroup;
    }

    /**
     * @param string $bannersGroup
     * @param string $viewedBanners
     * @return string
     * @throws LocalizedException
     */
    public function getRandomBanner($bannersGroup, $storeIds, $viewedBanners = '0')
    {
        $currentDate = $this->date->date('Y.m.d');
        $this->searchCriteriaBuilder
            ->addFilter('group_code', $bannersGroup)
            ->addFilter('shown_store_id', $storeIds, 'finset')
            ->addFilter('banner_id', $viewedBanners, 'nin')
            ->addFilter('show_start_date', $currentDate, 'lteq')
            ->addFilter('show_end_date', $currentDate, 'gteq');

        $filter = $this->filter->setField('rand');
        $this->searchCriteriaBuilder->addFilters([$filter]);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $banners = $this->bannerRepository->getList($searchCriteria)->getItems();
        $banner = reset($banners);

        if ($banner) {
            $banner = $banner->getData();
            return $this->jsonSerializer->serialize($banner);
        } else {
            throw new LocalizedException(__('Banner not found'));
        }
    }

    /**
     * @return bool|mixed|string
     */
    public function getBanner()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $filter = $this->filter
            ->setField('store_id')
            ->setValue(1213123);
        $filterGroup = $this->filterGroup->setFilters([$filter]);
        $searchCriteria->setFilterGroups([$filterGroup]);
        $banners = $this->bannerRepository->getList($searchCriteria)->getItems();
        $res = [];

        foreach ($banners as $banner) {
            $res[] = $banner->getData();
        }

        return $this->jsonSerializer->serialize($res);
    }
}
