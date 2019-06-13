<?php

namespace BabaYaga\Checkout\Plugin;

use Amazon\Payment\Api\OrderInformationManagementInterface;
use Amazon\Payment\Domain\AmazonConstraint;
use Closure;
use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Api\ShippingInformationManagementInterface;
use Magento\Customer\Api\Data\AddressExtension;
use Magento\Quote\Api\CartRepositoryInterface;
use Amazon\Login\Helper\Session as LoginSessionHelper;
use Magento\Quote\Model\QuoteRepository;

/**
 * Class AddInfoToQuoteAddress
 *
 * @package BabaYaga\Checkout\Plugin
 */
class AddInfoToQuoteAddress
{
    protected $quoteRepository;

    public function __construct(QuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * So the docs say that you should configure an extension attribute for Magento/Quote/Api/Data/AddressInterface.php
     * and show you that the data is retrieved from a ShippingInformationInterface instance.
     *
     * https://devdocs.magento.com/guides/v2.3/howdoi/checkout/checkout_new_field.html
     *
     * You must configure both in extension_attributes.xml (see example).
     *
     * Here we copy the additional_info attribute value from the shipping information interface extension attributes
     * to the quote address.
     *
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param                                                       $cartId
     * @param ShippingInformationInterface                          $addressInformation
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        if (!$extAttributes = $addressInformation->getExtensionAttributes()) {
            return;
        }

        $quote = $this->quoteRepository->getActive($cartId);
        $address = $quote->getShippingAddress();
        $address->setAdditionalInfo($extAttributes->getAdditionalInfo());
    }
}
