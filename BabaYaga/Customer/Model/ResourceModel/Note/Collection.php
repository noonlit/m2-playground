<?php

namespace BabaYaga\Customer\Model\ResourceModel\Note;

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
        $this->_init('BabaYaga\Customer\Model\Note', 'BabaYaga\Customer\Model\ResourceModel\Note');
    }
}
