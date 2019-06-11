<?php

namespace BabaYaga\Sales\Controller\Test;

use Magento\Framework\Api\FilterBuilder;
use \Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class Test
 *
 * @package BabaYaga\Customer\Controller\Test
 */
class Test extends Action
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

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
     * @param Context                  $context
     * @param OrderRepositoryInterface $orderRepository
     * @param FilterBuilder            $filterBuilder
     * @param SearchCriteriaBuilder    $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        OrderRepositoryInterface $orderRepository,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->orderRepository = $orderRepository;
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
        $this->demoUseOfExtensionAttributes();
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function demoUseOfExtensionAttributes()
    {
        // Load a (potentially) note-less order.
        $orderId = 1;
        $order = $this->orderRepository->get($orderId);

        // Save a note on the order.
        $attributes = $order->getExtensionAttributes();
        $attributes->setMerchantNote('This is a note with id ' . uniqid());
        $this->orderRepository->save($order); // the note will be saved in the sales_order table.

        // Reload the order and retrieve the note.
        $updatedOrder = $this->orderRepository->get($orderId);
        $note = $updatedOrder->getExtensionAttributes()->getMerchantNote(); // thanks to the AddMerchantNoteToOrder plugin, we have the note.

        // Get a list of orders and retrieve their notes.
        $filter = $this->filterBuilder->create()
            ->setField('entity_id')
            ->setValue($orderId)
            ->setConditionType('gteq');
        $searchCriteria = $this->searchCriteriaBuilder->addFilter($filter)->create();
        $repoList = $this->orderRepository->getList($searchCriteria);

        $notes = [];
        foreach ($repoList->getItems() as $item) {
            $notes[] = $item->getExtensionAttributes()->getMerchantNote();
        }

        // Convenient breakpoint location. Check content of $note and $notes.
        $breakpoint = true;
    }
}
