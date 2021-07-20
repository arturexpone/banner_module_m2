<?php

namespace M2task\BannerManagement\Model\Banner;

use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use M2task\BannerManagement\Model\ResourceModel\Banner\CollectionFactory;


class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var M2task\BannerManagement\Model\ResourceModel\Banner\Collection
     */
    protected $collection;

    /**
     * @var
     */
    protected $loadedData;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;


    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bannerCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannerCollectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannerCollectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $banner) {
            $this->loadedData[$banner->getId()] = $banner->getData();
        }
        return $this->loadedData;
    }
}
