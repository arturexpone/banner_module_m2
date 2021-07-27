<?php

namespace M2task\BannerManagement\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

use M2task\BannerManagement\Api\Data\BannerInterface;
use M2task\BannerManagement\Api\Data\BannerSearchResultInterfaceFactory;
use M2task\BannerManagement\Api\BannerRepositoryInterface;
use M2task\BannerManagement\Model\ResourceModel\BannerResource;
use M2task\BannerManagement\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;


class BannerRepository implements BannerRepositoryInterface
{
    /**
     * @var BannerFactory
     */
    private $bannerFactory;
    /**
     * @var BannerCollectionFactory
     */
    private $bannerCollectionFactory;
    /**
     * @var BannerSearchresultFactory
     */
    private $searchResultFactory;

    /**
     * @var BannerSearchResultInterfaceFactory
     */
    private $bannerSearchResultInterfaceFactory;
    private $bannerResource;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        BannerFactory $bannerFactory,
        BannerCollectionFactory $bannerCollectionFactory,
        BannerSearchResultInterfaceFactory $bannerSearchResultInterfaceFactory,
        BannerResource $bannerResource,
        \M2task\BannerManagement\Model\BannerSearchResultFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->bannerSearchResultInterfaceFactory = $bannerSearchResultInterfaceFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->bannerResource = $bannerResource;
        $this->collectionProcessor = $collectionProcessor;
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
     * @param \M2task\BannerManagement\Api\Data\BannerInterface $banner
     * @return \M2task\BannerManagement\Api\Data\BannerInterface
     */
    public function save(BannerInterface $banner)
    {
        $this->bannerResource->save($banner);
        return $banner;
    }

    /**
     * @param BannerInterface $banner
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BannerInterface $banner)
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

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var TYPE_NAME $collection */
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }



}
