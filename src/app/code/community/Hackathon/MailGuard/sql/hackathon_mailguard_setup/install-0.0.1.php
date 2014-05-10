<?php
/**
 * @var $this Mage_Core_Model_Resource_Setup
 */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()->newTable($installer->getTable('hackathon_mailguard/address'))
    ->addColumn('address_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
    ), 'Increment Id')
    ->addColumn('mailaddress', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Mail address pattern')
    ->addColumn('type', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Entry type');

$installer->getConnection()->createTable($table);

$installer->endSetup();