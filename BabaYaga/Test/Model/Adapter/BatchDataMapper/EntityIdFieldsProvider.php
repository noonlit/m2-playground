<?php
declare(strict_types=1);

namespace BabaYaga\Test\Model\Adapter\BatchDataMapper;


use Magento\AdvancedSearch\Model\Adapter\DataMapper\AdditionalFieldsProviderInterface;

/**
 * Provide data mapping for price fields
 */
class EntityIdFieldsProvider implements AdditionalFieldsProviderInterface
{
    /**
     * @inheritdoc
     */
    public function getFields(array $productIds, $storeId)
    {
        $fields = [];
        foreach ($productIds as $productId) {
            $fields[$productId] = ['entity_id' => $productId];
        }

        return $fields;
    }
}
