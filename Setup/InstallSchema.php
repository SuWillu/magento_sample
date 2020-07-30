<?php
/**
 * Copyright © 2017 Xertigo. 
 */

namespace Xertigo\MyMeasurements\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'xertigo_mymeasurements_shirts'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('xertigo_mymeasurements_customshirt')
        )->addColumn(
            'xertigo_mymeasurements_customshirt_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Measurement Id'
       )->addColumn(
            'customer_id', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false], 'Customer Id'
       )->addColumn(
            'nameOnShirt',
            Table::TYPE_TEXT,
            20,
            [],
            'Name on Laundry Tag'
        )->addColumn(
            'fitStyle',
            Table::TYPE_TEXT,
            30,
            [],
            'Fit Style'
        )->addColumn(
            'neckSize',
            Table::TYPE_TEXT,
            30,
            [],
            'Neck Size'
        )->addColumn(
            'collarStyle',
            Table::TYPE_TEXT,
            30,
            [],
            'Collar Style'
        )->addColumn(
            'whiteCollar',
            Table::TYPE_TEXT,
            '30',
            [],
            'White Collar'
        )->addColumn(
            'sleeve',
            Table::TYPE_TEXT,
            '30',
            [],
            'Sleeve'
        )->addColumn(
            'cuff',
            Table::TYPE_TEXT,
            '30',
            [],
            'Cuff'
        )->addColumn(
            'pocket',
            Table::TYPE_TEXT,
            '10',
            [],
            'Pocket'
        )->addColumn(
            'monogram',
            Table::TYPE_TEXT,
            '30',
            [],
            'Monogram'
        )->addColumn(
            'monogramInitials',
            Table::TYPE_TEXT,
            '30',
            [],
            'Monogram Initials'
        )->addColumn(
            'monogramStyle',
            Table::TYPE_TEXT,
            '30',
            [],
            'Monogram Style'
        )->addColumn(
            'digitalSignature',
            Table::TYPE_TEXT,
            '30',
            [],
            'Digital Signature'
        )->addColumn(
            'monogramColor',
            Table::TYPE_TEXT,
            '30',
            [],
            'Monogram Color'
        )->addColumn(
            'monogramPlace',
            Table::TYPE_TEXT,
            '30',
            [],
            'Monogram Place'
        )->addColumn(
            'measurementName',
            Table::TYPE_TEXT,
            '30',
            [],
            'Measurement Name'
        )->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            array (
            ),
           'Creation Time'
        )->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            array (
            ),
           'Modification Time'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            array (
                'nullable' => false,'default' => '1',
            ),
                'Is Active'
        )->setComment('Custom Measurements Table');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}