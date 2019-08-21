<?php
namespace BabaYaga\Vendor\Model\ResourceModel;

/**
 * Class Vendor
 *
 * @package BabaYaga\Customer\Model\ResourceModel
 */
class Vendor extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize table.
     */
    protected function _construct()
    {
        $this->_init('vendor_entity', 'entity_id');
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $id) : array
    {
        $conn = $this->getConnection();

        $select = $conn->select()->from($this->getMainTable())->where('entity_id = :id');

        $bind = [':id' => (int) $id];

        return $conn->fetchRow($select, $bind);

    }
}
