<?php
namespace BabaYaga\Route\App\Router;

use Magento\Framework\App\Router\NoRouteHandlerInterface;

/**
 * Class NoRouteHandler
 *
 * @package BabaYaga\Route\Router
 */
class NoRouteHandler implements NoRouteHandlerInterface
{
    /**
     * Check and process no route request.
     *
     * Redirect to homepage.
     *
     * @param \Magento\Framework\App\RequestInterface $request
     *
     * @return bool
     */
    public function process(\Magento\Framework\App\RequestInterface $request)
    {
        $request->setModuleName('cms')->setControllerName('index')->setActionName('index');

        return true;
    }
}
