<?php

namespace BabaYaga\Checkout\Plugin;

use Magento\Checkout\Block\Checkout\LayoutProcessor;
use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Eav\Model\Config;

/**
 * Class AddFieldsToCheckout
 *
 * @package BabaYaga\Checkout\Plugin
 */
class AddFieldsToCheckout
{
    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * AddFieldsToCheckout constructor.
     *
     * @param Config $eavConfig
     */
    public function __construct(Config $eavConfig)
    {
        $this->eavConfig = $eavConfig;
    }

    /**
     * @param LayoutProcessor $subject
     * @param array           $jsLayout
     *
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $jsLayout
    ) {
        return $this->addInfoFieldToShipping($jsLayout);
    }

    /**
     * Adds the address additional info field to the shipping address on the checkout page.
     *
     * @param array $jsLayout
     *
     * @return array
     */
    private function addInfoFieldToShipping(array $jsLayout) : array
    {
        $attributeCode = 'additional_info';

        $field = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template'    => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'tooltip' => [
                    'description' => 'Additional information about this address.',
                ],
            ],
            'dataScope'   => 'shippingAddress.custom_attributes.' . $attributeCode,
            'label'       => __('Extra'),
            'provider'    => 'checkoutProvider',
            'sortOrder'   => 150,
            'options'     => [],
            'filterBy'    => null,
            'customEntry' => null,
            'visible'     => true,
        ];

        if ($this->isAttributeRequired($attributeCode)) {
            $field['validation'] = ['required-entry' => true];
        }

        return $this->addFieldToShippingAddress($jsLayout, $attributeCode, $field);
    }


    /**
     * Checks whether the attribute is required.
     *
     * @param string $attributeCode
     *
     * @return bool
     */
    protected function isAttributeRequired(string $attributeCode)
    {
        try {
            return (bool) $this->eavConfig->getAttribute(AddressMetadataInterface::ENTITY_TYPE_ADDRESS, $attributeCode)->getIsRequired();
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Adds the given field to the shipping address fieldset.
     *
     * @param array $jsLayout
     * @param       $attributeCode
     * @param       $field
     *
     * @return array
     */
    private function addFieldToShippingAddress(array $jsLayout, $attributeCode, $field)
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'][$attributeCode] = $field;

        return $jsLayout;
    }
}
