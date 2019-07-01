<?php

namespace BabaYaga\Customer\Controller\Adminhtml\Note;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 *
 * @package BabaYaga\Customer\Controller\Adminhtml\Note
 */
class Index extends Action
{
    const ADMIN_RESOURCE = 'BabaYaga_Customer::manage';

    /**
     * Will render the notes grid.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
