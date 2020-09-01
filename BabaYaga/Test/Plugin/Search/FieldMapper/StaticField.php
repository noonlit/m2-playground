<?php

declare(strict_types=1);

namespace BabaYaga\Test\Plugin\Search\FieldMapper;

use Magento\Elasticsearch\Model\Adapter\FieldMapper\Product\FieldProvider\FieldType\ConverterInterface;

class StaticField
{
    /**
     * @param $subject
     * @param $result
     * @return mixed
     */
    public function afterGetFields($subject, $result)
    {
        $result['entity_id'] = ['type' => ConverterInterface::INTERNAL_DATA_TYPE_INT, 'store' => true];

        return $result;
    }
}
