<?php

namespace M2task\BannerGraphQl\Controller\Banner;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\Api\Filter;
use Magento\Store\Model\StoreManagerInterface;

use M2task\BannerGraphQl\Api\BannerRepositoryInterface;


class Index implements HttpGetActionInterface
{
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
    private $bannerRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var array
     */
    private $randomBanner;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Filter $filter,
        StoreManagerInterface $storeManager
    )
    {
        $this->_jsonFactory = $jsonFactory;
        $this->context = $context;
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filter = $filter;
        $this->storeManager = $storeManager;
    }

    /**
     * @param $data
     * @return mixed|string|null
     */
    public function getBannerData($data) {
        if (!isset($this->randomBanner)) return null;
        return $this->randomBanner[$data] ?? '';
    }

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
                UrlInterface::URL_TYPE_MEDIA
            ) . 'banners/tmp/banner/';
    }

    /**
     * @return $this
     */
    public function setRandomBanner($bannerGroupCode, $viewedBanners) {
        if (!isset($this->randomBanner)) {
            $currentDate = date('Y.m.d');
            $filter = $this->filter->setField('rand');

            $this->searchCriteriaBuilder
                ->addFilter('group_code', $bannerGroupCode)
                ->addFilter('banner_id', $viewedBanners, 'nin')
                ->addFilter('show_start_date', $currentDate, 'lteq')
                ->addFilter('show_end_date', $currentDate, 'gteq');
            $this->searchCriteriaBuilder->addFilters([$filter]);

            $searchCriteria = $this->searchCriteriaBuilder->create();
            $banners = $this->bannerRepository->getList($searchCriteria)->getItems();

            if (count($banners) > 0) {
                $randomBanner = $banners[array_key_first($banners)]->getData();
                $this->randomBanner = $randomBanner;
            }
        }
        return $this;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $res = $this->_jsonFactory->create();

        $reqParams = $this->context->getRequest()->getParams();
        $bannerGroupCode = $reqParams['group_code'];
        $viewedBanners = $reqParams['viewed_banners'];

        $this->setRandomBanner($bannerGroupCode, $viewedBanners);

        if (!$this->randomBanner) {
            $res->setHttpResponseCode(\Magento\Framework\Webapi\Exception::HTTP_NOT_FOUND);
            $res->setData(['error_message' => 'Banner not found']);
            return $res;
        }

        foreach ($this->randomBanner as $key => &$val) {
            if ($key === 'mobile_image' || $key === 'desktop_image') {
                $val = $this->getMediaUrl() . $val;
            }
        }

        return $res->setData($this->randomBanner);
    }

}
