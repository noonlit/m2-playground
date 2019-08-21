<?php

namespace BabaYaga\Vendor\Controller\Marketplace;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\ActionInterface;

class Router implements RouterInterface
{

    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var HttpResponse
     */
    protected $response;

    /**
     * @var \Magento\UrlRewrite\Model\UrlFinderInterface
     */
    protected $urlFinder;

    /**
     * @param \Magento\Framework\App\ActionFactory       $actionFactory
     * @param UrlInterface                               $url
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\ResponseInterface   $response
     * @param UrlFinderInterface                         $urlFinder
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        UrlInterface $url,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\ResponseInterface $response,
        UrlFinderInterface $urlFinder
    ) {
        $this->actionFactory = $actionFactory;
        $this->url = $url;
        $this->storeManager = $storeManager;
        $this->response = $response;
        $this->urlFinder = $urlFinder;
    }

    /**
     * Match corresponding URL Rewrite and modify request.
     *
     * @param RequestInterface|HttpRequest $request
     *
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request)
    {
        $actionClassName = 'BabaYaga\Vendor\Controller\Test\NewAction';
        $actionInstance = $this->actionFactory->create($actionClassName);

        return $actionInstance;
    }

}
