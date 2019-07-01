<?php

namespace BabaYaga\Customer\Ui;

use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 *
 * @package BabaYaga\Customer\Ui
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var \BabaYaga\Customer\Model\ResourceModel\Note\Collection
     */
    protected $collection;

    /**
     * DataProvider constructor.
     *
     * @param       $name
     * @param       $primaryFieldName
     * @param       $requestFieldName
     * @param       $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * @return array
     */
    public function getData()
    {
        $result = [];
        foreach ($this->collection->getItems() as $item) {
            $result[$item->getId()]['general'] = $item->getData();
        }
        return $result;
    }
}
