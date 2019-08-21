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
     * Returns mock data.
     *
     * // TODO figure out why setup:di:compile throws error for this class.
     *
     * @return array
     */
    public function getData()
    {
        $result = [];
        $result[1]['general'] = ['customer_id' => 1, 'text' => 'this is text'];

        return $result;
    }
}
