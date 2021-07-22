<?php

namespace M2task\BannerGraphQl\Model\Resolver;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

use M2task\BannerGraphql\Api\BannerRepositoryInterface;

class GetRandomBanner implements ResolverInterface
{
    /**
     * @var string
     */
    private $group_code;
    /**
     * @var string
     */
    private $viewed_banners;
    /**
     * @var array
     */
    private $randomBanner;
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
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Filter $filter,
        StoreManagerInterface $storeManager
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filter = $filter;
        $this->storeManager = $storeManager;
    }


    public function getMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
                UrlInterface::URL_TYPE_MEDIA
            ) . 'banners/tmp/banner/';
    }

    public function setRandomBanner() {
        if (!isset($this->randomBanner)) {
            $currentDate = date('Y.m.d');
            $filter = $this->filter->setField('rand');

            $this->searchCriteriaBuilder
                ->addFilter('group_code', $this->group_code)
                ->addFilter('banner_id', $this->viewed_banners, 'nin')
                ->addFilter('show_start_date', $currentDate, 'lteq')
                ->addFilter('show_end_date', $currentDate, 'gteq');

            $this->searchCriteriaBuilder->addFilters([$filter]);

            $searchCriteria = $this->searchCriteriaBuilder->create();
            $banners = $this->bannerRepository->getList($searchCriteria)->getItems();

            if (count($banners) > 0) {
                $randomBanner = $banners[array_key_first($banners)]->getData();
                $this->randomBanner = $randomBanner;
            }
        }
        return $this;
    }

    public function setMediaUrlToBanner() {
        foreach ($this->randomBanner as $key => &$val) {
            if ($key === 'mobile_image' || $key === 'desktop_image') {
                $val = $this->getMediaUrl() . $val;
            }
        }
    }

    public function checkReqParams(&$args) {
        $requiredParams = ['group_code', 'viewed_banners'];

        foreach ($requiredParams as $value) {
            if (!isset($args[$value]) || empty($args[$value]))
            {
                throw new GraphQlInputException(__('Invalid parameter list.'));
            }
            $this->$value = $args[$value];
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

        $this->checkReqParams($args)->setRandomBanner();

        if (!$this->randomBanner) {
            throw new GraphQlNoSuchEntityException(__('Banner not found'));
        }

        $this->setMediaUrlToBanner();

        return $this->randomBanner;
    }
}
