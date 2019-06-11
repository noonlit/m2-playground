<?php

namespace BabaYaga\Sales\Block\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class OrderHistory
 *
 * @package BabaYaga\Sales\Block\ViewModel
 */
class OrderHistory implements ArgumentInterface
{
    /**
     * Method for testing view model usage in template.
     */
    public function getFlavourText()
    {
        return "There is dark treasure over the hill";
    }
}
