<?php
namespace BabaYaga\Sales\Model\Quote\Address\Total;

/**
 * Class WitchyDiscount
 *
 * @package BabaYaga\Sales\Model\Quote\Address\Total
 */
class WitchyDiscount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * WitchyDiscount constructor.
     *
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(\Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency)
    {
        $this->priceCurrency = $priceCurrency;
        $this->setCode('witchy_discount');
    }

    /**
     * Apply a discount of 10 to the order total.
     *
     * The total will be displayed with the discount applied (e.g. a total of 59$ will become 49$).
     *
     * @param \Magento\Quote\Model\Quote                          $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total            $total
     *
     * @return \Magento\Quote\Model\Quote\Address\Total\AbstractTotal|void
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $baseDiscount = 10;
        $discount = $this->priceCurrency->convert($baseDiscount);

        $total->addTotalAmount($this->getCode(), -$discount);
        $total->addBaseTotalAmount($this->getCode(), -$baseDiscount);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() -$baseDiscount);
        $quote->setData($this->getCode(), -$discount);
    }

    /**
     * Retrieve data about the discount. The format followed is that of the grand total.
     *
     * @param \Magento\Quote\Model\Quote               $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     *
     * @return array
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        return [
            'code'  => $this->getCode(),
            'title' => __('Witchy Discount'),
            'value' => -10
        ];
    }
}
