<?php

namespace BabaYaga\Customer\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     *
     * @throws \Zend_Db_Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            $this->installCustomerNote($setup);
        }
    }

    /**
     * Installs the customer_note table, which will hold notes added to customers.
     *
     * @param SchemaSetupInterface $setup
     *
     * @throws \Zend_Db_Exception
     */
    private function installCustomerNote(SchemaSetupInterface $setup)
    {
        $conn = $setup->getConnection();

        $tableName = $conn->getTableName('customer_note');

        if ($conn->isTableExists($tableName)) {
            $conn->dropTable($tableName);
        }

        $table = $conn->newTable($tableName)
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true
                ]
            )
            ->addColumn(
                'customer_id',
                Table::TYPE_INTEGER,
                10,
                [
                    'nullable' => false,
                    'unsigned' => true
                ]
            )
            ->addColumn(
                'text',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ]
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default'  => Table::TIMESTAMP_INIT
                ]
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default'  => Table::TIMESTAMP_INIT_UPDATE
                ]
            )
            ->addForeignKey(
                $setup->getFkName(
                    $tableName,
                    'customer_id',
                    'customer_entity',
                    'entity_id'
                ),
                'customer_id',
                $setup->getTable('customer_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            );

        $conn->createTable($table);
    }
}
