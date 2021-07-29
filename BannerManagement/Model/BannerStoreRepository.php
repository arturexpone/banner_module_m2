<?php

namespace M2task\BannerManagement\Model;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

use M2task\BannerManagement\Api\Data\BannerStoreInterface;
use M2task\BannerManagement\Api\Data\BannerStoreSearchResultInterfaceFactory;
use M2task\BannerManagement\Api\BannerStoreRepositoryInterface;
use M2task\BannerManagement\Model\ResourceModel\BannerStore;
use M2task\BannerManagement\Model\ResourceModel\BannerStore\CollectionFactory as BannerStoreCollectionFactory;


class BannerStoreRepository implements BannerStoreRepositoryInterface
{
    /**
     * @var BannerStoreFactory
     */
    private $bannerFactory;
    /**
     * @var BannerStoreCollectionFactory
     */
    private $bannerCollectionFactory;
    /**
     * @var BannerStoreSearchresultFactory
     */
    private $searchResultFactory;

    /**
     * @var BannerStoreSearchResultInterfaceFactory
     */
    private $bannerSearchResultInterfaceFactory;
    private $bannerResource;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var Filter
     */
    private $filterBuilder;
    /**
     * @var FilterGroup
     */
    private $filterGroupBuilder;

    public function __construct(
        BannerStoreFactory $bannerFactory,
        BannerStoreCollectionFactory $bannerCollectionFactory,
        BannerStoreSearchResultInterfaceFactory $bannerSearchResultInterfaceFactory,
        BannerStore $bannerResource,
        \M2task\BannerManagement\Model\BannerStoreSearchResultFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor,
        \Magento\Framework\Api\Filter $filterBuilder,
        FilterGroup $filterGroupBuilder
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->bannerSearchResultInterfaceFactory = $bannerSearchResultInterfaceFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->bannerResource = $bannerResource;
        $this->collectionProcessor = $collectionProcessor;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
    }

    /**
     * @param $id
     * @return Banner|mixed
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $banner = $this->bannerFactory->create();
        $this->bannerResource->load($banner, $id);
        if (!$banner->getId()) {
            throw new NoSuchEntityException(__('Unable to find Banner with ID "%1"', $id));
        }
        return $banner;
    }

    /**
     * @param \M2task\BannerManagement\Api\Data\BannerStoreInterface $banner
     * @return \M2task\BannerManagement\Api\Data\BannerStoreInterface
     */
    public function save(BannerStoreInterface $banner)
    {
        $this->bannerResource->save($banner);
        return $banner;
    }

    /**
     * @param BannerStoreInterface $banner
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BannerStoreInterface $banner)
    {
        try {
            $this->bannerResource->delete($banner);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;

    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->bannerCollectionFactory->create();
//        $searchCriteria->addFilter('store_id',true, 'null');
        $filter1 = $this->filterBuilder
            ->setField("store_id")
            ->setValue("1");
//            ->setConditionType("eq");

        $filter2 = $this->filterBuilder
            ->setField("store_id")
            ->setValue("1")
            ->setConditionType("neq");

        $filterGroup1 = $this->filterGroupBuilder->setFilters([$filter1]);

        $searchCriteria->setFilterGroups([$filterGroup1]);

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var TYPE_NAME $collection */
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

}
