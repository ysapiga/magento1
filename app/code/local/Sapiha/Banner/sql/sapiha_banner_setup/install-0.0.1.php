<?php

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$tableNews = $installer->getTable('sapiha_banner/table_banner');
$installer->startSetup();
$installer->getConnection()->dropTable($tableNews);
$table = $installer->getConnection()
    ->newTable($tableNews)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ))
    ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => false,
    ), 'Banner id')
    ->addColumn('click_count', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => true,
    ), 'amount of clicks');
$table  ->addForeignKey($installer->getFkName('sapiha_banner/table_banner', 'banner_id', 'widget/widget_instance', 'instance_id'),
    'banner_id', $installer->getTable('widget/widget_instance'), 'instance_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE,Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($table);
$installer->endSetup();
