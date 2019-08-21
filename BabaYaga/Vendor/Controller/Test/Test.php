<?php

namespace BabaYaga\Vendor\Controller\Test;

use BabaYaga\Vendor\Model\ResourceModel\Vendor;
use BabaYaga\Vendor\Model\VendorFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Test
 *
 * @package BabaYaga\Vendor\Controller\Test
 */
class Test extends Action
{
    private $vendorFactory;
    private $vendorResource;

    public function __construct(Context $context, VendorFactory $vendorFactory, Vendor $vendorResource)
    {
        $this->vendorFactory = $vendorFactory;
        $this->vendorResource = $vendorResource;

        parent::__construct($context);
    }


    public function execute()
    {
        /**
         * New vendor
         */
        $vendor = $this->vendorFactory->create();
        $vendor->setName('Baba');
        $this->vendorResource->save($vendor);

        /**
         * Existing vendor
         */
        $existingVendorData = $this->vendorResource->getById(1);

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
