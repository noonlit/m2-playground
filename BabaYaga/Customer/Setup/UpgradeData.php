<?php

namespace BabaYaga\Customer\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Sales\Model\Order;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $this->updateIsWitchAttribute($setup);
        }
    }

    /**
     * @param ModuleDataSetupInterface $setup
     */
    private function updateIsWitchAttribute(ModuleDataSetupInterface $setup)
    {
        /**
         * @var $eavSetup EavSetup
         */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $attributeCode = 'is_witch';

        $eavSetup->updateAttribute(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            $attributeCode,
            'note',
            'Attribute is not required but highly relevant.'
        );
    }
}
