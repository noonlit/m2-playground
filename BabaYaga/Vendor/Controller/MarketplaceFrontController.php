<?php

namespace BabaYaga\Vendor\Controller;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

class MarketplaceFrontController implements \Magento\Framework\App\FrontControllerInterface
{

    /** @var \Magento\Framework\App\ResponseInterface */
    protected $response;

    /** @var \Magento\Framework\App\State */
    protected $appState;

    /** @var \Magento\Framework\App\AreaList */
    protected $areaList;

    /** @var \Magento\Framework\Session\Generic */
    protected $session;

    /** @var \Magento\Framework\Module\ModuleListInterface */
    protected $moduleList;

    protected $router;

    /**
     * Initialize dependencies
     * @param \Magento\Framework\App\ResponseInterface      $response
     * @param \Magento\Framework\App\State                  $appState
     * @param \Magento\Framework\App\AreaList               $areaList
     * @param \Magento\Framework\Session\Generic            $session
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     */
    public function __construct(
        \Magento\Framework\App\ResponseInterface $response,
        \Magento\Framework\App\State $appState,
        \Magento\Framework\App\AreaList $areaList,
        \Magento\Framework\Session\Generic $session,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \BabaYaga\Vendor\Controller\Marketplace\Router $router
    ) {

        $this->response = $response;
        $this->appState = $appState;
        $this->areaList = $areaList;
        $this->session = $session;
        $this->moduleList = $moduleList;
        $this->router = $router;
    }

    /**
     * Dispatch application action
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        $actionInstance = $this->router->match($request);

        return $actionInstance->execute();
    }

    private function test()
    {
        $resp = "<html><body>\n";
        $resp .= "</body></html><h1>Application State</h1>\n";
        $resp .= "<table>\n";
        $resp .= "<tr><td>Session Name:</td><td>"
            .htmlspecialchars($this->session->getName())."</td></tr>\n";
        $resp .= "<tr><td>Cookie Domain:</td><td>"
            .htmlspecialchars($this->session->getCookieDomain())."</td></tr>\n";
        $resp .= "<tr><td>Cookie Path:</td><td>"
            .htmlspecialchars($this->session->getCookiePath())."</td></tr>\n";
        $resp .= "<tr><td>Cookie Lifetime:</td><td>"
            .htmlspecialchars($this->session->getCookieLifetime())."</td></tr>\n";

        $resp .= "<tr><td>Application State:</td><td>"
            .htmlspecialchars($this->appState->getMode())."</td></tr>\n";

        $resp .= "<tr valign='top'><td>Areas:</td><td>";
        $resp .= "<table>";
        foreach ($this->areaList->getCodes() as $areaCode) {
            $resp .= "<tr><td>".htmlspecialchars($areaCode)."</td><td>/"
                .$this->areaList->getFrontName($areaCode)."</td></tr>\n";
        }
        $resp .= "</table>";
        $resp .= "</td></tr>\n";

        $resp .= "<tr valign='top'><td>Modules:</td><td>";
        foreach ($this->moduleList->getAll() as $moduleName => $module) {
            $resp .= $moduleName."<br />\n";
        }
        $resp .= "</td></tr>\n";

        $resp .= "</table>\n";
        $resp .= "</body></html>\n";

        $this->response->setBody($resp);

        return $this->response;
    }
}
