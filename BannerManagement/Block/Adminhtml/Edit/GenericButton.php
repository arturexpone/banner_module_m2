<?php

namespace M2task\BannerManagement\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use M2task\BannerManagement\Model\BannerFactory;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var BannerFactory
     */
    protected $bannerFactory;

    /**
     * @param Context $context
     * @param BannerFactory $bannerFactory
     */
    public function __construct(
        Context $context,
        BannerFactory $bannerFactory
    ) {
        $this->context = $context;
        $this->bannerFactory = $bannerFactory;
    }

    /**
     * Return Label ID
     *
     * @return int|null
     */
    public function getBannerId()
    {
        try {
            return $this->context->getRequest()->getParam('id');
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
