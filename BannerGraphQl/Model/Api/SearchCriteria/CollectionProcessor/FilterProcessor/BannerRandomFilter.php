<?php


namespace M2task\BannerGraphQl\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor;


use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;

class BannerRandomFilter implements CustomFilterInterface
{

    public function apply(Filter $filter, AbstractDb $collection)
    {
        return true;
    }
}
