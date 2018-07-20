<?php

$installer = $this;
$tableExport = $installer->getTable('sapiha_export/table_export');
$installer->startSetup();
$installer->getConnection()->dropTable($tableExport);
$table = $installer->getConnection()
    ->newTable($tableExport)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ))
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(
            'nullable'  => false,
        ))
    ->addColumn('format', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(
        'nullable'  => false,
    ))
    ->addColumn('file_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, '50', array(
        'nullable'  => false,
    ))
    ->addColumn('category_ids', Varien_Db_Ddl_Table::TYPE_TEXT, '1000', array(
    'nullable'  => false,
    ))
    ->addColumn('minimum_qty', Varien_Db_Ddl_Table::TYPE_INTEGER, '11', array(
    'nullable'  => false,
    ))
    ->addColumn('action', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(
        'nullable'  => true,
    ))
    ->addColumn('markdown', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(
        'nullable'  => true,
    ))
    ->addColumn('providers', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(
        'nullable'  => true,
    ))
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable'  => false,
    ));
$installer->getConnection()->createTable($table);

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttribute('catalog_product', 'action', array(
    'group' => 'General',
    'type' => 'text',
    'label' => 'Action',
    'input' => 'select',
    'source' => 'sapiha_export/product_source_action',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => false,
));
$setup->addAttribute('catalog_product', 'provider', array(
    'group' => 'General',
    'type' => 'text',
    'label' => 'Provider',
    'input' => 'select',
    'source' => 'sapiha_export/product_source_provider',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => false,
));
$setup->addAttribute('catalog_product', 'markdown', array(
    'group' => 'General',
    'type' => 'text',
    'label' => 'Markdown',
    'input' => 'select',
    'source' => 'sapiha_export/product_source_markdown',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => false,
));

$installer->endSetup();
