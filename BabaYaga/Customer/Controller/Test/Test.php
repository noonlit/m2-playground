<?php

namespace BabaYaga\Customer\Controller\Test;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
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
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Test constructor.
     *
     * @param Context                     $context
     * @param CustomerRepositoryInterface $customerRepository
     * @param FilterBuilder               $filterBuilder
     * @param SearchCriteriaBuilder       $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->customerRepository = $customerRepository;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        // $this->demoUseOfCustomAttributes();
        $this->demoUseOfExtensionAttributes();
    }

    /**
     * Retrieval and persistence test for custom attributes.
     *
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
        $updatedValue = is_null($isWitchUpdated) ? false : (bool) $isWitchUpdated->getValue();

        // Convenient breakpoint location.
        $breakpoint = true;
    }

    /**
     * Retrieval and persistence test for extension attributes.
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function demoUseOfExtensionAttributes()
    {
        /**
         * Get + extension attribute (courtesy of AddCustomerNoteToOrder plugin)
         */
        $customerId = 1;
        $customer = $this->customerRepository->getById($customerId);
        $repoResult = $customer->getExtensionAttributes()->getCustomerNote();

        /**
         * Get list + extension attribute
         */
        $filter = $this->filterBuilder->create()
            ->setField('entity_id')
            ->setValue(1)
            ->setConditionType('gteq');
        $searchCriteria = $this->searchCriteriaBuilder->addFilter($filter)->create();
        $list = $this->customerRepository->getList($searchCriteria);

        /**
         * Save + extension attribute
         */
        $customers = $list->getItems();
        foreach ($customers as $customer) {
            $customer->getExtensionAttributes()->getCustomerNote()->setText(uniqid());
            $this->customerRepository->save($customer);
        }

        // set breakpoint here
        $breakpoint = true;
    }
}
