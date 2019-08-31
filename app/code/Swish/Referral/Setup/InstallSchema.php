<?php
/**
 * Created by PhpStorm.
 * User: kharidas
 * Date: 31.08.19
 * Time: 01:32
 */

namespace Swish\Referral\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Swish\Referral\Api\RelationsInterface;
use Magento\Framework\DB\Ddl\Table;
use Exception;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        try {
            /**
             * Create table 'referral_program'
             */
            $table = $installer->getConnection()
                ->newTable($installer->getTable(RelationsInterface::TABLE_NAME))
                ->addColumn(
                    RelationsInterface::FIELD_NAME_ID,
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Entity ID'
                )
                ->addColumn(
                    RelationsInterface::FIELD_NAME_CUSTOMER_ID,
                    Table::TYPE_TEXT,
                    128,
                    ['nullable' => false],
                    'Customer ID'
                )
                ->addColumn(
                    RelationsInterface::FIELD_NAME_REFERRAL_ID,
                    Table::TYPE_TEXT,
                    128,
                    ['nullable' => true],
                    'Referral ID'
                )->addColumn(
                    RelationsInterface::FIELD_NAME_REFERRAL_REWARD,
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => true],
                    'Reward'
                )->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created Time'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Update Time'
                )
                ->addIndex(
                    $installer->getIdxName(RelationsInterface::TABLE_NAME, [RelationsInterface::FIELD_NAME_CUSTOMER_ID]),
                    [RelationsInterface::FIELD_NAME_CUSTOMER_ID]
                )
                ->addIndex(
                    $installer->getIdxName(RelationsInterface::TABLE_NAME, [RelationsInterface::FIELD_NAME_REFERRAL_ID]),
                    [RelationsInterface::FIELD_NAME_REFERRAL_ID]
                )
                ->setComment('Referral Program');
            $installer->getConnection()->createTable($table);
        } catch (Exception $e) {
            null;
        }
        $installer->endSetup();
    }
}
