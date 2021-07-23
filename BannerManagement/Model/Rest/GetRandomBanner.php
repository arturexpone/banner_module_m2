<?php

namespace M2task\BannerManagement\Model\Rest;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Serialize\Serializer\Json;

use M2task\BannerManagement\Api\GetRandomBannerInterface;
use M2task\BannerManagement\Api\BannerRepositoryInterface;

class GetRandomBanner implements GetRandomBannerInterface
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
     * @param $searchCriteriaParams
     * @return mixed
     * @throws LocalizedException
     */
    public function getRandomBanner($searchCriteriaParams)
    {

        foreach ($searchCriteriaParams as $filterParams) {
            $this->searchCriteriaBuilder
                ->addFilter($filterParams['field'], $filterParams['value'], $filterParams['conditionType']);
        }

        $filter = $this->filter->setField('rand');
        $this->searchCriteriaBuilder->addFilters([$filter]);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $banners = $this->bannerRepository->getList($searchCriteria)->getItems();
        $banner = reset($banners);

        if ($banner) {
            return $banner->getData();
        } else {
            throw new LocalizedException(__('Banner not found'));
        }
    }

    /**
     * @param string $banners_group
     * @param string $viewed_banners
     * @return string
     * @throws LocalizedException
     */
    public function exec($banners_group, $viewed_banners = '0')
    {
        $currentDate = $this->date->date('Y.m.d');
        $searchCriteriaParams = [
            [
                'field' => 'group_code',
                'value' => $banners_group,
                'conditionType' => 'eq'
            ],
            [
                'field' => 'banner_id',
                'value' => $viewed_banners,
                'conditionType' => 'nin'
            ],
            [
                'field' => 'show_start_date',
                'value' => $currentDate,
                'conditionType' => 'lteq'
            ],
            [
                'field' => 'show_end_date',
                'value' => $currentDate,
                'conditionType' => 'gteq'
            ]
        ];

        $randomBanner = $this->getRandomBanner($searchCriteriaParams);

        return $this->jsonSerializer->serialize($randomBanner);
    }

}
