<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();
/**
 * Create table 'sapiha_guestalert/price'
 */
$tablePrice = $installer->getConnection()
    ->newTable($installer->getTable('sapiha_guestalert/table_price'));

$tablePrice->addColumn(
    'product_price_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    null,
    ['identity'  => true, 'unsigned'  => true, 'nullable'  => false, 'primary'   => true,],
    'Product alert price id'
    )
    ->addColumn(
        'product_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        ['unsigned'  => true, 'nullable'  => false, 'default'   => '0',],
        'Product id'
    )
    ->addColumn(
        'price',
        Varien_Db_Ddl_Table::TYPE_DECIMAL,
        '12,4',
        ['nullable'  => false, 'default'   => '0.0000',],
        'Price amount'
    )
    ->addColumn(
        'guest_name',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        ['unsigned'  => true, 'nullable'  => false,],
        'guest name')
    ->addColumn(
        'guest_email',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        ['unsigned'  => true, 'nullable'  => false,],
        'guest email'
    )
    ->addForeignKey(
        $installer->getFkName(
            'sapiha_guestalert/table_price',
            'product_id',
            'catalog/product',
            'entity_id'
        ),
    'product_id',
        $installer->getTable(
            'catalog/product'
        ),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );

$installer->getConnection()->createTable($tablePrice);

/**
 * Create table 'sapiha_guestalert/stock'
 */
$tableStock = $installer->getConnection()
    ->newTable($installer->getTable('sapiha_guestalert/table_stock'));

$tableStock->addColumn(
    'product_stock_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    null,
    ['identity'  => true, 'unsigned'  => true, 'nullable'  => false, 'primary'   => true,],
    'Product alert stock id'
    )
    ->addColumn(
        'product_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        ['unsigned'  => true, 'nullable'  => false, 'default'   => '0',],
        'Product id 1'
    )
    ->addColumn(
        'price',
        Varien_Db_Ddl_Table::TYPE_DECIMAL,
        '12,4',
        ['nullable'  => false, 'default'   => '0.0000',],
        'Price amount'
    )
    ->addColumn(
        'guest_name',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        ['unsigned'  => true, 'nullable'  => false,],
        'guest name1'
    )
    ->addColumn(
        'guest_email',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        ['unsigned'  => true, 'nullable'  => false,],
        'guest email1'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        ['unsigned'  => true, 'nullable'  => false, 'default'   => '0',],
        'Product alert status1'
    )
    ->addForeignKey(
        $installer->getFkName(
            'sapiha_guestalert/table_stock',
            'product_id',
            'catalog/product',
            'entity_id'
        ),
    'product_id',
        $installer->getTable(
            'catalog/product'
        ),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );

$installer->getConnection()->createTable($tableStock);

$installer->endSetup();
