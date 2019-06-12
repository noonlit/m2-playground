<?php

namespace BabaYaga\Customer\Setup\Patch\Data;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

/**
 * Class AddOccupation
 *
 * @package BabaYaga\Customer\Setup\Patch
 */
class AddOccupation implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var SetFactory
     */
    private $attributeSetFactory;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Attribute
     */
    private $customerAttributeResource;

    /**
     * AddOccupation constructor.
     *
     * @param ModuleDataSetupInterface                        $moduleDataSetup
     * @param CustomerSetupFactory                            $customerSetupFactory
     * @param SetFactory                                      $attributeSetFactory
     * @param \Magento\Customer\Model\ResourceModel\Attribute $customerAttributeResource
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        SetFactory $attributeSetFactory,
        \Magento\Customer\Model\ResourceModel\Attribute $customerAttributeResource
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->customerAttributeResource = $customerAttributeResource;
    }

    /**
     * Add info attribute to customer address.
     *
     * @return DataPatchInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function apply()
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $attributeCode = 'info';

        $customerSetup->removeAttribute(AddressMetadataInterface::ENTITY_TYPE_ADDRESS, 'info');

        /**
         * Create EAV attribute.
         */
        $customerSetup->addAttribute(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            $attributeCode,
            [
                'label'        => 'Extra info',
                'type'         => 'text',
                'required'     => 0,
                'visible'      => 1,
                'user_defined' => 1,
                'system'       => 0,
                'position'     => 150
            ]
        );

        /**
         * Add attribute to customer address attribute set and group.
         */
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(AddressMetadataInterface::ENTITY_TYPE_ADDRESS);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var $attributeSet \Magento\Eav\Model\Entity\Attribute\Set */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttributeToSet(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            AddressMetadataInterface::ATTRIBUTE_SET_ID_ADDRESS,
            $attributeGroupId,
            $attributeCode
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute(
            AddressMetadataInterface::ATTRIBUTE_SET_ID_ADDRESS,
            $attributeCode
        );

        /**
         * Set the forms the attribute should be used in.
         */
        $attribute->setData(
            'used_in_forms',
            [
                'adminhtml_checkout',
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address',
            ]
        );

        $this->customerAttributeResource->save($attribute);
    }

    /**
     * Removes the info attribute from the customer address.
     */
    public function revert()
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $customerSetup->removeAttribute(AddressMetadataInterface::ATTRIBUTE_SET_ID_ADDRESS, 'info');
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
