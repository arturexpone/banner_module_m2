<?php

namespace M2task\BannerGraphQl\Model\Resolver;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\DateTime;

use M2task\BannerManagement\Api\BannerRepositoryInterface;

class GetRandomBanner implements ResolverInterface
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

    public function __construct(
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Filter $filter,
        DateTime $date
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filter = $filter;
        $this->date = $date;
    }

    public function getRandomBanner($searchCriteriaParams) {

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
                throw new GraphQlNoSuchEntityException(__('Banner not found'));
            }
    }

    public function checkReqParams($checkingParams, $args) {
        foreach ($checkingParams as $param) {
            if (!isset($args[$param]) || empty($args[$param]))
            {
                throw new GraphQlInputException(__('Invalid parameter list.'));
            }
        }

        return $this;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null)
    {
        $this->checkReqParams(['group_code'], $args);

        $currentDate = $this->date->date('Y.m.d');
        $searchCriteriaParams = [
            [
                'field' => 'group_code',
                'value' => $args['group_code'],
                'conditionType' => 'eq'
            ],
            [
                'field' => 'banner_id',
                'value' => $args['viewed_banners'],
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

        return $this->getRandomBanner($searchCriteriaParams);
    }
}
