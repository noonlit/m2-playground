<?php

namespace BabaYaga\Checkout\Block\Cart;

/**
 * Class ItemRenderer
 *
 * @package BabaYaga\Checkout\Block\Cart
 */
class ItemRenderer extends \Magento\Checkout\Block\Cart\Item\Renderer
{
    /**
     * Returns a shuffled version of the product name.
     *
     * @return string
     */
    public function getProductName()
    {
        return str_shuffle($this->getProduct()->getName());
    }
}
