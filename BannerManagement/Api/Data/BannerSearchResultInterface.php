<?php


namespace M2task\BannerManagement\Api\Data;
use Magento\Framework\Api\SearchResultsInterface;

interface BannerSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems();


    /**
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return BannerSearchResultInterface
     */
    public function setItems(array $items);

}
