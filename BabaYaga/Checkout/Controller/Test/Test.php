<?php

namespace BabaYaga\Checkout\Controller\Test;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteRepository;

class Test extends Action
{
    /**
     * @var QuoteRepository
     */
    private $quoteRepository;

    /**
     * @var Quote\Item\ToOrderItem
     */
    private $orderItemConverter;

    /**
     * Test constructor.
     *
     * @param Context                $context
     * @param QuoteRepository        $quoteRepository
     * @param Quote\Item\ToOrderItem $converter
     */
    public function __construct(Context $context, QuoteRepository $quoteRepository, Quote\Item\ToOrderItem $converter)
    {
        $this->quoteRepository = $quoteRepository;
        $this->orderItemConverter = $converter;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $id = 29;
        /**
         * @var Quote $quote
         */
        $quote = $this->quoteRepository->get($id);
        $items = $quote->getAllVisibleItems();

        /**
         * @var $item Quote\Item
         */
        foreach ($items as $item) {
            // Add options to quote item.
            $additionalOptions = ['label' => uniqid('label'), 'value' => uniqid('value')];
            $item->addOption(
                [
                    'code' => 'additional_options',
                    'value' => serialize($additionalOptions)
                ]
            );

            // Save options to quote_item_option.
            $item->saveItemOptions();

            // Check if options are retained on order item.
            $orderItem = $this->orderItemConverter->convert($item);

            // Spoiler: they are not. You'll need to customize Magento\Catalog\Model\Product\Type\AbstractType::getOrderOptions($product)

            // The product itself does have the additional_options custom option set,
            // but it is not considered something that should be transferred to the order item.

            // Then the options can be retrieved with $orderItem->getProductOptions();

            $breakpoint = true;
        }

    }
}
