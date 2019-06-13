<?php

namespace BabaYaga\Catalog\Setup\Patch\Data;

use BabaYaga\Catalog\Model\Product\Type\Spellbook;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class AddInfoToCustomerAddress
 *
 * @package BabaYaga\Customer\Setup\Patch\Data
 */
class AddAttributesToSpellbookProduct implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * AddAttributesToSpellbookProduct constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory          $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @return DataPatchInterface|void
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        // initialize list of attributes that should be applicable to the product
        $fieldList = [
            'price',
            'special_price',
            'special_from_date',
            'special_to_date',
            'minimal_price',
            'tier_price',
            'weight',
        ];

        // make these attributes applicable to our product
        foreach ($fieldList as $field) {
            $applyTo = explode(
                ',',
                $eavSetup->getAttribute(\Magento\Catalog\Model\Product::ENTITY, $field, 'apply_to')
            );

            $productType = Spellbook::TYPE_ID;

            if (in_array($productType, $applyTo)) {
                continue;
            }

            $applyTo[] = $productType;

            $eavSetup->updateAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                $field,
                'apply_to',
                implode(',', $applyTo)
            );
        }
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }
}
