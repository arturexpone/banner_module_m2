<?php
namespace M2task\BannerManagement\Api;

interface BannerStoreRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param \M2task\BannerManagement\Api\Data\BannerStoreInterface $banner
     * @return \M2task\BannerManagement\Api\Data\BannerStoreInterface
     */
    public function save(\M2task\BannerManagement\Api\Data\BannerStoreInterface $banner);

    /**
     * @param Data\BannerStoreInterface $banner
     * @return mixed
     */
    public function delete(\M2task\BannerManagement\Api\Data\BannerStoreInterface $banner);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
