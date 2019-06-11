<?php

namespace BabaYaga\Customer\Setup;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

/**
 * Class InstallData
 *
 * @package BabaYaga\Customer\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Attribute
     */
    private $customerAttributeResource;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * InstallData constructor.
     *
     * @param EavSetupFactory                                 $eavSetupFactory
     * @param Config                                          $config
     * @param \Magento\Customer\Model\ResourceModel\Attribute $customerAttributeResource
     * @param AttributeSetFactory                             $attributeSetFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $config,
        \Magento\Customer\Model\ResourceModel\Attribute $customerAttributeResource,
        AttributeSetFactory $attributeSetFactory
    )
    {
        $this->eavConfig = $config;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerAttributeResource = $customerAttributeResource;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * @var $eavSetup EavSetup
         */
        $eavSetup      = $this->eavSetupFactory->create(['setup' => $setup]);
        $attributeCode = 'is_witch';

        $eavSetup->removeAttribute(CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, $attributeCode);

        /**
         * Create EAV attribute.
         *
         * Check:
         * - magento/module-customer/Model/ResourceModel/Setup/PropertyMapper.php
         * - magento/module-eav/Model/Entity/Setup/PropertyMapper.php
         */
        $eavSetup->addAttribute(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            $attributeCode,
            [
                'type'            => 'int',
                'label'           => 'Is the Customer a Witch?!',
                'input'           => Table::TYPE_BOOLEAN,
                'source'          => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'required'        => 0,
                'visible'         => 1,
                'user_defined'    => 1,
                'position'        => 999,
                'system'          => 0
            ]
        );

        /**
         * Add attribute to customer attribute set.
         */

        $attributeSetId = CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER;

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $eavSetup->addAttributeToSet(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            $attributeSetId,
            $attributeGroupId,
            $attributeCode
        );

        /**
         * Add attribute to forms.
         *
         * (see table customer_form_attribute)
         */
        $attribute = $this->eavConfig->getAttribute(CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, $attributeCode);
        $attribute->setData('used_in_forms', [
            'adminhtml_customer',
            'customer_account_create',
            'customer_account_edit'
        ]);

        /**
         * On Mage2tv, you will see this:
         *
         * $attribute->getResource()->save($attribute);
         *
         * but the getResource() method is deprecated, so we will use the resource model directly.
         */

        $this->customerAttributeResource->save($attribute);
    }

}
