<?php

namespace M2task\BannerManagement\Model\Api\SearchCriteria\CollectionProcessor\JoinProcessor;

use Magento\Framework\Api\ExtensionAttribute\JoinDataInterfaceFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\JoinProcessor\CustomJoinInterface;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Class Rate
 * @package Magento\Tax\Model\Api\SearchCriteria\JoinProcessor
 **/
class Rate implements CustomJoinInterface
{

    /**
     * @var JoinDataInterfaceFactory
     */
    private $joinDataFactory;

    /**
     * @var JoinProcessorInterface
     */
    private $joinProcessor;


    public function __construct(
        JoinDataInterfaceFactory $joinDataFactory,
        JoinProcessorInterface $joinProcessor
    ) {
        $this->joinDataFactory = $joinDataFactory;
        $this->joinProcessor = $joinProcessor;
    }

    /**
     * @param \Magento\Tax\Model\ResourceModel\Calculation\Rule\Collection $collection
     * @return true
     **/
    public function apply(AbstractDb $collection)
    {

        $collection->getSelect()->joinLeft(
            ['b' => $collection->getTable('banner')],
            "b.banner_id = main_table.banner_id"
        );

        $collection->getSelect()->group('main_table.banner_id');

        return true;
    }
}
