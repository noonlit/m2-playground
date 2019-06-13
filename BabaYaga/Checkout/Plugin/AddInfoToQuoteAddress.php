<?php

namespace BabaYaga\Checkout\Plugin;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Model\ShippingInformationManagement;
use Magento\Quote\Model\QuoteRepository;

/**
 * Class AddInfoToQuoteAddress
 *
 * @package BabaYaga\Checkout\Plugin
 */
class AddInfoToQuoteAddress
{
    /**
     * @var QuoteRepository
     */
    protected $quoteRepository;

    /**
     * AddInfoToQuoteAddress constructor.
     *
     * @param QuoteRepository $quoteRepository
     */
    public function __construct(QuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * The docs say that you should configure an extension attribute for Magento/Quote/Api/Data/AddressInterface.php
     * and show you that the extension attribute data is retrieved from a ShippingInformationInterface instance.
     *
     * https://devdocs.magento.com/guides/v2.3/howdoi/checkout/checkout_new_field.html
     *
     * You must configure both extension attributes in extension_attributes.xml (see example in this module).
     *
     * Here we copy the additional_info attribute value from the shipping information interface extension attributes
     * to the quote address.
     *
     * @param ShippingInformationManagement $subject
     * @param                               $cartId
     * @param ShippingInformationInterface  $addressInformation
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSaveAddressInformation(
        ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        if (!$extAttributes = $addressInformation->getExtensionAttributes()) {
            return;
        }

        $quote = $this->quoteRepository->getActive($cartId);
        $address = $quote->getShippingAddress();
        $address->setAdditionalInfo($extAttributes->getAdditionalInfo());
    }
}
