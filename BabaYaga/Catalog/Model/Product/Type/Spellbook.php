<?php

namespace BabaYaga\Catalog\Model\Product\Type;

/**
 * Class Spellbook
 *
 * @package BabaYaga\Catalog\Product\Type
 */
class Spellbook extends \Magento\Catalog\Model\Product\Type\AbstractType
{
    /**
     * This product's type id.
     */
    const TYPE_ID = 'spellbook';

    /**
     * The base class has only this abstract method.
     *
     * "This oddly specific method is called during a product instance save if its type has changed,
     * and gives the original product type the opportunity to clean up any type-specific data
     * before the type change is finalized."
     *
     * Implementation unnecessary for now.
     *
     * @param \Magento\Catalog\Model\Product $product
     */
    public function deleteTypeSpecificData(\Magento\Catalog\Model\Product $product)
    {
        // TODO: Implement deleteTypeSpecificData() method.
    }
}
