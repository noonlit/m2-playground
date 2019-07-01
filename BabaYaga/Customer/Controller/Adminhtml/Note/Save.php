<?php

namespace BabaYaga\Customer\Controller\Adminhtml\Note;

use BabaYaga\Customer\Model\Note;
use BabaYaga\Customer\Model\NoteFactory;

/**
 * Class Save
 *
 * @package BabaYaga\Customer\Controller\Adminhtml\Note
 */
class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'BabaYaga_Customer::manage';

    /**
     * @var NoteFactory
     */
    private $noteFactory;

    /**
     * @var \BabaYaga\Customer\Model\ResourceModel\Note
     */
    private $noteResource;

    /**
     * Save constructor.
     *
     * @param \Magento\Backend\App\Action\Context         $context
     * @param NoteFactory                                 $noteFactory
     * @param \BabaYaga\Customer\Model\ResourceModel\Note $noteResource
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        NoteFactory $noteFactory,
        \BabaYaga\Customer\Model\ResourceModel\Note $noteResource
    ) {
        $this->noteFactory = $noteFactory;
        $this->noteResource = $noteResource;
        parent::__construct($context);
    }

    /**
     * Will save a new customer note.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        /**
         * @var $note Note
         */
        $note = $this->noteFactory->create();
        $note->setData($this->getRequest()->getPostValue()['general']);
        $this->noteResource->save($note);

        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }
}
