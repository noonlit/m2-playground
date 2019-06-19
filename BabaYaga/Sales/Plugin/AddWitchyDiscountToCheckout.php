<?php

namespace BabaYaga\Sales\Plugin;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

/**
 * Class AddWitchyDiscountToCheckout
 *
 * @package BabaYaga\Sales\Plugin
 */
class AddWitchyDiscountToCheckout
{
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
        return $this->addWitchyDiscount($jsLayout);
    }

    /**
     * Adds the custom discount to the layout, as a totals child.
     *
     * @param array $jsLayout
     *
     * @return array
     */
    private function addWitchyDiscount(array $jsLayout): array
    {
        $data = [
            'component' => 'BabaYaga_Sales/js/view/checkout/cart/totals/witchy_discount',
            'config'    => [
                'title'    => __('Witchy Discount'),
                'template' => 'BabaYaga_Sales/checkout/cart/totals/witchy_discount'
            ]
        ];

        $jsLayout['components']['checkout']['children']['sidebar']['children']['summary']['children']
        ['totals']['children']['witchy_discount'] = $data;

        return $jsLayout;
    }
}
