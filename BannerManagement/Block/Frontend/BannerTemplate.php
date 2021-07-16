<?php

namespace M2task\BannerManagement\Block\Frontend;

use Magento\Framework\View\Element\Template;

class BannerTemplate extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlInterface;

    /**
     * Index constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Framework\UrlInterface $urlInterface,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->urlInterface = $urlInterface;
    }

    public function getBaseUrl()
    {
        return $this->urlInterface->getBaseUrl();
    }
}
