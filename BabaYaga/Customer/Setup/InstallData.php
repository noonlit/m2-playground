<?php

namespace BabaYaga\Customer\Setup;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\MetadataInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

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
     * InstallData constructor.
     *
     * @param EavSetupFactory                                 $eavSetupFactory
     * @param Config                                          $config
     * @param \Magento\Customer\Model\ResourceModel\Attribute $customerAttributeResource
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $config,
        \Magento\Customer\Model\ResourceModel\Attribute $customerAttributeResource
    )
    {
        $this->eavConfig = $config;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerAttributeResource = $customerAttributeResource;
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
                'input'           => 'boolean',
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
        $eavSetup->addAttributeToSet(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER,
            null,
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
