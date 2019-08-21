<?php

namespace BabaYaga\Vendor\Controller\Adminhtml\Vendor;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 *
 * @package BabaYaga\Customer\Controller\Adminhtml\Note
 */
class Index extends Action
{
    const ADMIN_RESOURCE = 'BabaYaga_Vendor::manage';

    /**
     * Will render the vendors grid.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
