<?php

namespace BabaYaga\Customer\Plugin;

use BabaYaga\Customer\Model\ResourceModel\CustomerNoteRepository;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionFactory;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Class AddCustomerNoteToOrder
 *
 * @package BabaYaga\Customer\Plugin
 */
class AddCustomerNoteToCustomer
{
    const ATTRIBUTE_CODE = 'customer_note';

    /**
     * @var CustomerExtensionFactory
     */
    private $customerExtensionFactory;

    /**
     * @var CustomerNoteRepository
     */
    private $customerNoteRepository;

    /**
     * AddCustomerNoteToOrder constructor.
     *
     * @param CustomerExtensionFactory $customerExtensionFactory
     * @param CustomerNoteRepository   $customerNoteRepository
     */
    public function __construct(CustomerExtensionFactory $customerExtensionFactory, CustomerNoteRepository $customerNoteRepository)
    {
        $this->customerExtensionFactory = $customerExtensionFactory;
        $this->customerNoteRepository = $customerNoteRepository;
    }

    /**
     * Sets the customer note on the customer after retrieval.
     *
     * See https://devdocs.magento.com/guides/v2.3/extension-dev-guide/extension_attributes/adding-attributes.html#add-plugin-to-product-repository.
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $entity
     *
     * @return CustomerInterface
     */
    public function afterGet(CustomerRepositoryInterface $subject, CustomerInterface $entity)
    {
        $this->setExtensionAttribute($entity);

        return $entity;
    }

    /**
     * The docs do not mention this but it is needed.
     *
     * Sets the customer note on the customer after retrieval.
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $entity
     *
     * @return CustomerInterface
     */
    public function afterGetById(CustomerRepositoryInterface $subject, CustomerInterface $entity)
    {
        return $this->afterGet($subject, $entity);
    }

    /**
     * Adds the customer note to every customer retrieved by the repository.
     *
     * @param CustomerRepositoryInterface                   $subject
     * @param \Magento\Framework\Api\SearchResultsInterface $searchResult
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function afterGetList(
        CustomerRepositoryInterface $subject,
        \Magento\Framework\Api\SearchResultsInterface $searchResult
    ) {
        $customers = $searchResult->getItems();

        foreach ($customers as $customer) {
            $this->setExtensionAttribute($customer);
        }

        return $searchResult;
    }

    /**
     * Saves extension attribute too.
     *
     * See https://devdocs.magento.com/guides/v2.3/extension-dev-guide/extension_attributes/adding-attributes.html#add-plugin-to-product-repository
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $entity
     *
     * @return CustomerInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function afterSave(CustomerRepositoryInterface $subject, CustomerInterface $entity)
    {
        $note = $entity->getExtensionAttributes()->getCustomerNote();

        $this->customerNoteRepository->save($note);

        return $entity;
    }

    /**
     * Sets the customer note object as an extension attribute of the customer entity.
     *
     * @param CustomerInterface $entity
     */
    private function setExtensionAttribute(CustomerInterface $entity)
    {
        $note = $this->customerNoteRepository->getByCustomerId($entity->getId());

        $extensionAttributes = $entity->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->customerExtensionFactory->create();

        $extensionAttributes->setCustomerNote($note); // note that the method is autocompleted by the IDE, because the CustomerExtension class has been generated
        $entity->setExtensionAttributes($extensionAttributes);
    }
}
