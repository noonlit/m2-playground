<?php

namespace BabaYaga\Customer\Controller\Test;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

/**
 * Class Test
 *
 * @package BabaYaga\Customer\Controller\Test
 */
class Test extends Action
{

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * Test constructor.
     *
     * @param Context                     $context
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $this->demoUseOfCustomAttributes();
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function demoUseOfCustomAttributes()
    {
        /**
         * Get all custom attributes for customer.
         */
        $customerId = 1;
        $customer = $this->customerRepository->getById($customerId);
        $customerCustomAttributes = $customer->getCustomAttributes();

        /**
         * Get specific custom attribute for customer.
         */
        $isWitch = $customer->getCustomAttribute('is_witch');
        $value = is_null($isWitch) ? false : (bool) $isWitch->getValue();

        /**
         * Switch the value to check that it saves.
         */
        $customer->setCustomAttribute('is_witch', !$value);
        $this->customerRepository->save($customer);
        
        $updatedCustomer = $this->customerRepository->getById($customerId);
        $isWitchUpdated = $customer->getCustomAttribute('is_witch');
        $updatedValue = is_null($isWitchUpdated) ? false : (bool)$isWitchUpdated->getValue();

        // Convenient breakpoint location.
        $breakpoint = true;
    }
}
