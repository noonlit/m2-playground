<?php

namespace BabaYaga\Checkout\Model;

/**
 * Class ShippingInformationManagement
 *
 * @package BabaYaga\Checkout\Model
 */
class ShippingInformationManagement extends \Magento\Checkout\Model\ShippingInformationManagement
{
    /**
     * @param int                                                     $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     *
     * @return \Magento\Checkout\Api\Data\PaymentDetailsInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function saveAddressInformation(
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {

        // test that interception works on this class
        $breakpoint = true;

        return parent::saveAddressInformation($cartId, $addressInformation);
    }
}
