<?php

namespace M2task\BannerManagement\Model\Rest;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Serialize\Serializer\Json;

use M2task\BannerManagement\Api\BannerStoreRestInterface;
use M2task\BannerManagement\Api\BannerStoreRepositoryInterface;

class BannerStore implements BannerStoreRestInterface
{
    /**
     * @var BannerStoreRepositoryInterface
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
     * @param BannerStoreRepositoryInterface $bannerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Filter $filter
     * @param DateTime $date
     * @param Json $jsonSerializer
     */
    public function __construct(
        BannerStoreRepositoryInterface $bannerRepository,
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
     * @return string
     * @throws LocalizedException
     */
    public function getBanner()
    {
        $currentDate = $this->date->date('Y.m.d');
//        $this->searchCriteriaBuilder
//            ->addFilter('store_id', '1', 'in');

//        $filter = $this->filter->setField('rand');
        $this->searchCriteriaBuilder
            ->addFilter('store_id',true, 'notnull');
//        $this->searchCriteriaBuilder->addFilters([$filter]);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $banners = $this->bannerRepository->getList($searchCriteria)->getItems();
        $res = [];
        foreach ($banners as $banner) {
            $res[] = $banner->getData();
        }
        return $this->jsonSerializer->serialize($res);
        $banner = reset($banners);

        if ($banner) {
            $banner = $banner->getData();
            return $this->jsonSerializer->serialize($banner);
        } else {
            throw new LocalizedException(__('Banner not found'));
        }
    }
}
