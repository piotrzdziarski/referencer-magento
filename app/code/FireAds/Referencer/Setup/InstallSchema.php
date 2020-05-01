<?php

namespace FireAds\Referencer\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\DeploymentConfig;

class InstallSchema implements InstallSchemaInterface
{
    private $customerFactory;
    private $setup;
    private $deploymentConfig;

    public function __construct(CustomerFactory $customerFactory, DeploymentConfig $deploymentConfig)
    {
        $this->customerFactory = $customerFactory;
        $this->deploymentConfig = $deploymentConfig;
    }

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->setup = $setup;
        $this->setup->startSetup();
        $this->createFireAdsActivitiesTable();
        $this->addFireAdsKeyToTable('customer_entity');
        $this->addFireAdsKeyToTable('sales_order');
        $this->setup->endSetup();
    }

    private function createFireAdsActivitiesTable()
    {
        /**
         * Each unique redirect creates row in this table.
         * Thanks to this table we know how much activity user created in shop.
         */
        $fireAdsActivities = $this->setup->getTable('fireads_activities');

        if (!$this->setup->getConnection()->isTableExists($fireAdsActivities)) {
            $table = $this->setup->getConnection()
                ->newTable($fireAdsActivities)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'primary' => true,
                        'nullable' => false
                    ],
                    'ID'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_DATETIME,
                    null,
                    [],
                    'Created At'
                )
                ->addColumn(
                    'total_entries',
                    TABLE::TYPE_INTEGER,
                    null,
                    [],
                    'Total entries of user'
                )
                ->addColumn(
                    'has_registered',
                    TABLE::TYPE_BOOLEAN,
                    null,
                    [],
                    'Has referenced user registered?'
                )
                ->setComment('FireAds Referencer Activity');

            $this->setup->getConnection()->createTable($table);
        }
    }

    private function addFireAdsKeyToTable($table)
    {
        $entity = $this->setup->getTable($table);

        if (!$this->setup->getConnection()->tableColumnExists($entity, 'fireads_key')) {
            $this->setup->getConnection()->addColumn(
                $entity,
                'fireads_key',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'primary' => false,
                    'nullable' => true,
                    'comment' => 'FireAds key'
                ],
                $this->deploymentConfig->get('db/connection/default/dbname')
            );
        }
    }
}
