<?php
declare(strict_types=1);

namespace Elogic\CreateTable\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface as DB;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

class InstallSchema implements InstallSchemaInterface
{
    private string $shopsTableName = 'flush795_shops_list';
    private string $addressesTableName = 'flush795_shops_addresses';
    private string $shopWorkSchedule = 'flush_shop_work_schedule';

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->installWorkSchedule($setup, $this->shopWorkSchedule);
        $this->installAddresses($setup, $this->addressesTableName);
        $this->installShop($setup, $this->shopsTableName);
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param string $shopsTableName
     * @throws Zend_Db_Exception
     */
    private function installShop(SchemaSetupInterface $setup, string $shopsTableName):void
    {
        $setup->startSetup();
        $table = $setup->getConnection()->newTable($setup->getTable($shopsTableName));


        $table->addColumn('id', Table::TYPE_INTEGER, null, [
            'primary' => true,
            'identity' => true,
            'unsigned' => true,
            'nullable' => false
        ]);
        $table->addColumn('name', Table::TYPE_TEXT, 255, [
            'nullable' => false,
            'description' => 'Shop Name'
        ]);
        $table->addColumn('description', Table::TYPE_TEXT, null, [
            'nullable' => false,
            'description' => 'Shop Description'
        ]);
        $table->addColumn('image', Table::TYPE_TEXT, 255, [
            'nullable' => false,
            'description' => 'Image link'
        ]);
        $table->addColumn('longitude', Table::TYPE_TEXT, 70, [
            'nullable' => false,
            'description' => 'Shop Google Maps Longitude'
        ]);
        $table->addColumn('latitude', Table::TYPE_TEXT, 70, [
            'nullable' => false,
            'description' => 'Shop Google Maps Latitude'
        ]);
        $table->addColumn('shop_address_id', Table::TYPE_INTEGER, null, [
            'unsigned' => true
        ]);
        $table->addForeignKey(
            $setup->getConnection()->getForeignKeyName(
                $shopsTableName,
                'shop_address_id',
                $setup->getConnection()->getTableName('flush795_shops_addresses'),
                'shop_address_id'
            ),
            'shop_address_id',
            $setup->getConnection()->getTableName('flush795_shops_addresses'),
            'shop_address_id',
            DB::FK_ACTION_CASCADE
        );


        $table->addColumn('shop_schedule_id', Table::TYPE_INTEGER, null, [
            'unsigned' => true,
        ]);
        $table->addForeignKey(
            $setup->getConnection()->getForeignKeyName(
                $shopsTableName,
                'shop_schedule_id',
                $setup->getConnection()->getTableName($this->shopWorkSchedule),
                'shop_schedule_id'
            ),
            'shop_schedule_id',
            $setup->getConnection()->getTableName($this->shopWorkSchedule),
            'shop_schedule_id',
            DB::FK_ACTION_CASCADE
        );
        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param string $addressesTableName
     * @throws Zend_Db_Exception
     */
    private function installAddresses(SchemaSetupInterface $setup, string $addressesTableName): void
    {
        $setup->startSetup();
        $table = $setup->getConnection()->newTable($setup->getTable($addressesTableName));

        $table->addColumn('shop_address_id', Table::TYPE_INTEGER, null, [
            'primary' => true,
            'identity' => true,
            'unsigned' => true,
            'nullable' => false
        ]);
        $table->addColumn('city', Table::TYPE_TEXT, 255, [
            'nullable' => false,
            'description' => 'City'
        ]);
        $table->addColumn('zip', Table::TYPE_TEXT, 100, [
            'nullable' => false,
            'description' => 'ZIP Code'
        ]);
        $table->addColumn('state', Table::TYPE_TEXT, 100, [
            'nullable' => false,
            'description' => 'Country'
        ]);
        $table->addColumn('address', Table::TYPE_TEXT, 255, [
            'nullable' => false,
            'description' => 'Address of store'
        ]);

        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param string $shopWorkSchedule
     * @throws Zend_Db_Exception
     */
    private function installWorkSchedule(SchemaSetupInterface $setup, string $shopWorkSchedule): void
    {
        $setup->startSetup();
        $table = $setup->getConnection()->newTable($setup->getTable($shopWorkSchedule));

        $table->addColumn('shop_schedule_id', Table::TYPE_INTEGER, null, [
            'primary' => true,
            'identity' => true,
            'unsigned' => true,
            'nullable' => false
        ]);
        $table->addColumn('monday', Table::TYPE_TEXT, 100, [
            'MON' => 'Monday'
        ]);
        $table->addColumn('tuesday', Table::TYPE_TEXT, 100, [
            'TUE' => 'Tuesday'
        ]);
        $table->addColumn('wednesday', Table::TYPE_TEXT, 100, [
            'WED' => 'Wednesday'
        ]);
        $table->addColumn('thursday', Table::TYPE_TEXT, 100, [
            'THU' => 'Thursday'
        ]);
        $table->addColumn('friday', Table::TYPE_TEXT, 100, [
            'FRI' => 'Friday'
        ]);
        $table->addColumn('saturday', Table::TYPE_TEXT, 100, [
            'SAT' => 'Saturday'
        ]);
        $table->addColumn('sunday', Table::TYPE_TEXT, 100, [
            'SUN' => 'Sunday'
        ]);


        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }
}
