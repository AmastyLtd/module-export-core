<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Test\Integration\TestModule\Setup\TestEntity1;

use Amasty\ExportCore\Test\Integration\TestModule\Model\ResourceModel\TestEntity1 as TestEntity1Resource;
use Magento\Framework\Setup\SchemaSetupInterface;

class DropTable
{
    /**
     * @var SchemaSetupInterface
     */
    private $schemaSetup;

    public function __construct(SchemaSetupInterface $schemaSetup)
    {
        $this->schemaSetup = $schemaSetup;
    }

    public function execute()
    {
        $tableName = $this->schemaSetup->getTable(TestEntity1Resource::TABLE_NAME);
        $this->schemaSetup->getConnection()->dropTable($tableName);
    }
}
