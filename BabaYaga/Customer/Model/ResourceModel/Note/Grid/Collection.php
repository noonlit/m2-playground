<?php

namespace BabaYaga\Customer\Model\ResourceModel\Note\Grid;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

/**
 * Class Collection
 *
 * @package BabaYaga\Customer\Model\ResourceModel\Note\Grid
 */
class Collection extends SearchResult
{
    /**
     * Add customer email to grid.
     *
     * @return SearchResult|void
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->joinInner(
            ['customer' => $this->getTable('customer_entity')],
            'main_table.customer_id = customer.entity_id',
            ['email']
        );
    }
}
