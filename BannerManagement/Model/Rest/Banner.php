<?php

namespace M2task\BannerManagement\Model\Rest;

use Magento\Framework\Api\Filter;
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
     * GetRandomBanner constructor.
     * @param BannerRepositoryInterface $bannerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Filter $filter
     * @param DateTime $date
     * @param Json $jsonSerializer
     */
    public function __construct(
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Filter $filter,
        DateTime $date,
        Json $jsonSerializer
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filter = $filter;
        $this->date = $date;
        $this->jsonSerializer = $jsonSerializer;
    }

    /**
     * @param string $banners_group
     * @param string $viewed_banners
     * @return string
     * @throws LocalizedException
     */
    public function getRandomBanner($banners_group, $storeIds, $viewed_banners = '0')
    {
        $currentDate = $this->date->date('Y.m.d');
        $this->searchCriteriaBuilder
            ->addFilter('group_code', $banners_group)
            ->addFilter('shown_store_id', $storeIds, 'finset')
            ->addFilter('banner_id', $viewed_banners, 'nin')
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
}
