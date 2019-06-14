<?php

namespace BabaYaga\Config\Controller\Test;

use BabaYaga\Config\Model\Config\Reader;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

/**
 * Class Test
 *
 * @package BabaYaga\Customer\Controller\Test
 */
class Test extends Action
{
    private $covensConfig;

    /**
     * Test constructor.
     *
     * @param Context $context
     * @param Reader    $covensConfig
     */
    public function __construct(Context $context, Reader $covensConfig)
    {
        $this->covensConfig = $covensConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        $config = $this->covensConfig->read();

        /**
         * convenient breakpoint location for inspecting the content of the $config.
         */
        $breakpoint = true;
    }


}
