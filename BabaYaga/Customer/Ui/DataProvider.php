<?php

namespace BabaYaga\Customer\Ui;

use BabaYaga\Customer\Model\ResourceModel\Note\CollectionFactory;
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
     * @param                    $name
     * @param                    $primaryFieldName
     * @param                    $requestFieldName
     * @param CollectionFactory  $collectionFactory
     * @param array              $meta
     * @param array              $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

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
