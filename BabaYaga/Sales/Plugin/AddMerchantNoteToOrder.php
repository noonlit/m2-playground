<?php

namespace BabaYaga\Sales\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class AddMerchantNoteToOrder
{
    const ATTRIBUTE_CODE = 'merchant_note';

    /**
     * @var OrderExtensionFactory
     */
    private $orderExtensionFactory;

    /**
     * AddMerchantNoteAttributeToOrder constructor.
     *
     * @param OrderExtensionFactory $orderExtensionFactory
     */
    public function __construct(OrderExtensionFactory $orderExtensionFactory)
    {
        $this->orderExtensionFactory = $orderExtensionFactory;
    }

    /**
     * Adds the merchant_note attribute to the order.
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface           $entity
     *
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $entity)
    {
        $this->setMerchantNoteExtensionAttribute($entity);

        return $entity;
    }

    /**
     * Adds the merchant_note attribute to every item in the list retrieved by the repo.
     *
     * @param OrderRepositoryInterface    $subject
     * @param \Magento\Framework\Api\SearchResultsInterface $searchResult
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, \Magento\Framework\Api\SearchResultsInterface $searchResult)
    {
        $orders = $searchResult->getItems();

        foreach ($orders as &$order) {
            $this->setMerchantNoteExtensionAttribute($order);
        }

        return $searchResult;
    }

    /**
     * Docs say we should implement afterSave(), but this is a value that belongs to the entity itself,
     * so we implement beforeSave().
     *
     * Set the extension attribute value on the entity itself.
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface           $entity
     *
     * @return array
     */
    public function beforeSave(OrderRepositoryInterface $subject, OrderInterface $entity)
    {
        $extensionAttributes = $entity->getExtensionAttributes();
        $value = $extensionAttributes->getMerchantNote();

        $entity->setMerchantNote($value);

        return [$entity];
    }

    /**
     * Retrieves the merchant note from the entity and sets it as an extension attribute.
     *
     * @param OrderInterface $entity
     */
    private function setMerchantNoteExtensionAttribute(OrderInterface $entity)
    {
        $value = $entity->getData('merchant_note');

        // add the attribute and value to the extension attributes
        $extensionAttributes = $entity->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->orderExtensionFactory->create();

        $extensionAttributes->setMerchantNote(
            $value
        ); // note that the method is autocompleted by the IDE, because the OrderExtension class has been generated

        $entity->setExtensionAttributes($extensionAttributes);
    }
}
