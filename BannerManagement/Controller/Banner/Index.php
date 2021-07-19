<?php

namespace M2task\BannerManagement\Controller\Banner;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\Filter;

use M2task\BannerManagement\Api\BannerRepositoryInterface;


class Index implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;
    /**
     * @var JsonFactory
     */
    protected $_jsonFactory;

    /**
     * @var Context
     */
    private $context;

    /**
     * @var BannerRepositoryInterface
     */
    private $testReporitory;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var SortOrder
     */
    private $sortOrder;
    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;
    /**
     * @var BannerFilterProcessor
     */
    private $bannerFilterProcessor;
    /**
     * @var Filter
     */
    private $filter;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        JsonFactory $jsonFactory,
        BannerRepositoryInterface $testReporitory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrder $sortOrder,
        SortOrderBuilder $sortOrderBuilder,
        Filter $filter
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_jsonFactory = $jsonFactory;
        $this->context = $context;
        $this->testReporitory = $testReporitory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrder = $sortOrder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->filter = $filter;
    }

    /**
     * @return array|null
     */
    private function getBannersData($data)
    {
        try {
            $currentDate = date('Y.m.d');
            $filter = $this->filter->setField('rand'); // Прилетает в коллекцию
            $this->searchCriteriaBuilder
                ->addFilter('banner_id', $data, 'nin')
                ->addFilter('show_start_date', $currentDate, 'lteq')
                ->addFilter('show_end_date', $currentDate, 'gteq');
            $this->searchCriteriaBuilder->addFilters([$filter]); // Прокидывает кастомный фильтр

            $searchCriteria = $this->searchCriteriaBuilder->create();
            $idRes = $this->testReporitory->getList($searchCriteria)->getItems();
            $res = [];

            foreach ($idRes as $banner) {
                $res[] = $banner->getData();
            }
            return $res;
        } catch (\Exception $exception) {
            throw new \Error($exception->getMessage());
            // ...
        }
    }

    public function getBannerToWidget($groupCode, $viewedBanners) {
        try {
            $filter = $this->filter->setField('rand');
            $this->searchCriteriaBuilder
                ->addFilter('group_code', $groupCode)
                ->addFilter('banner_id', $viewedBanners, 'nin');
            $this->searchCriteriaBuilder->addFilters([$filter]);

            $searchCriteria = $this->searchCriteriaBuilder->create();
            $banners = $this->testReporitory->getList($searchCriteria)->getItems();
            return $banners[array_key_first($banners)]->getData();
        } catch (\Exception $exception) {
            throw new \Error($exception->getMessage());
            // ...
        }
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $reqParams = $this->context->getRequest()->getParams();

        if (isset($reqParams['getBanner'])) {
            $res = $this->_jsonFactory->create();
            $viewedBannersIds = '';
            if (isset($reqParams['viewedBanners'])) {
                $viewedBannersIds = $reqParams['viewedBanners'];
            }
            return $res->setData(
                isset($reqParams['widgetGroupCode'])
                    ? $this->getBannerToWidget($reqParams['widgetGroupCode'], $viewedBannersIds)
                    : $this->getBannersData($viewedBannersIds));
        } else {
            throw new LocalizedException(__('Not request parameters'));
        }

    }

}
