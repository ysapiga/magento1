<?php

$installer = $this;
$tableKasaOrder = $installer->getTable('sapiha_kasa/table_kasa_order');
$installer->startSetup();
$installer->getConnection()->dropTable($tableKasaOrder);
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($tableKasaOrder)
    ->addColumn('robbery_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ))
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => false,
    ))
    ->addColumn('robbery_amount', Varien_Db_Ddl_Table::TYPE_FLOAT, 11, array(
        'nullable'  => true,
    ));
$table  ->addForeignKey($installer->getFkName('sapiha_kasa/table_kasa_order', 'order_id', 'sales/order', 'entity_id'),
    'order_id', $installer->getTable('sales/quote'), 'entity_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($table);

$installer->endSetup();
