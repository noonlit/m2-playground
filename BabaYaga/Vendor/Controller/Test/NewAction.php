<?php

namespace BabaYaga\Vendor\Controller\Test;

use BabaYaga\Vendor\Model\ResourceModel\Vendor;
use BabaYaga\Vendor\Model\VendorFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Test
 *
 * @package BabaYaga\Vendor\Controller\Test
 */
class NewAction extends Action
{
    private $auth;

    public function __construct(AuthorizationInterface $auth, Context $context)
    {
        $this->auth = $auth;

        parent::__construct($context);
    }

    public function execute()
    {
        $test = 'test';

        $allow = $this->auth->isAllowed('Evozon_Marketplace::view_products');



        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
