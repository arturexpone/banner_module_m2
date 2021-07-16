<?php


namespace M2task\BannerManagement\Model;

use M2task\BannerManagement\Api\BannerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Api\ProductRepositoryInterface;

class BannerCriteriaFilter
{
    /** @var ProductRepositoryInterface */
    protected $bannerRepository;

    /** @var SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /**
     * Initialize dependencies.
     *
     * @param BannerRepositoryInterface $bannerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Get products with filter.
     *
     * @param string $fieldName
     * @param string $fieldValue
     * @param string $filterType
     */
    public function getProducts($fieldName, $fieldValue)
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter($fieldName, $fieldValue)->create();
        $products = $this->bannerRepository->getList($searchCriteria);
        return $products->getItems();
    }

}
