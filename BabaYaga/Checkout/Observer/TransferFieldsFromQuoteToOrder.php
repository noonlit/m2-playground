<?php

namespace BabaYaga\Checkout\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class TransferFieldsFromQuoteToOrder
 *
 * @package BabaYaga\Checkout\Observer
 */
class TransferFieldsFromQuoteToOrder implements ObserverInterface
{

    /**
     * According to the docs, we should also have a \Magento\Framework\DataObject\Copy instance here,
     * which would copy our field values to the corresponding fieldsets if we configured them in fieldset.xml
     * (from quote address to order address).
     *
     * See: https://devdocs.magento.com/guides/v2.3/ext-best-practices/tutorials/copy-fieldsets.html#step-3
     *
     * This doesn't work as expected.
     *
     * We will copy the values directly.
     *
     * @param \Magento\Framework\Event\Observer $observert
     *
     * @return $this|void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getData('order');
        /* @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getData('quote');

        $orderAddress = $order->getShippingAddress();
        $quoteAddress = $quote->getShippingAddress();

        $orderAddress->setAdditionalInfo($quoteAddress->getAdditionalInfo());
    }
}

