<?php

namespace BabaYaga\Customer\Controller\Adminhtml\Note;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class NewAction
 *
 * @package BabaYaga\Customer\Controller\Adminhtml\Note
 */
class NewAction extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'BabaYaga_Customer::manage';

    /**
     * Will render a form to add a new note.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
