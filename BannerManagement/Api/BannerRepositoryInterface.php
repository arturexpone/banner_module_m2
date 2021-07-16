<?php
namespace M2task\BannerManagement\Api;

interface BannerRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param Data\BannerInterface $banner
     * @return mixed
     */
    public function save(\M2task\BannerManagement\Api\Data\BannerInterface $banner);

    /**
     * @param Data\BannerInterface $banner
     * @return mixed
     */
    public function delete(\M2task\BannerManagement\Api\Data\BannerInterface $banner);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
