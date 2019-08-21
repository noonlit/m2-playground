<?php

namespace BabaYaga\Vendor\Model\ResourceModel\Vendor;

/**
 * Class Collection
 *
 * @package BabaYaga\Customer\Model\ResourceModel\Note
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Initialize model and resource.
     */
    protected function _construct()
    {
        $this->_init('BabaYaga\Vendor\Model\Vendor', 'BabaYaga\Vendor\Model\ResourceModel\Vendor');
    }
}
