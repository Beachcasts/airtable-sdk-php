<?php

declare(strict_types=1);

namespace Beachcasts\AirtableTests\Unit;

use Beachcasts\Airtable\AirtableClient as AirtableClient;
use Beachcasts\Airtable\Config;
use Beachcasts\Airtable\Table;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

/**
 * Class TableTest
 * @package Beachcasts\Airtable
 */
class TableTest extends TestCase
{
    protected $table;

    protected function setUp(): void
    {

//        $config = Config::fromValues(
//            'https://baseurl.test',
//            'v0',
//            'api-key'
//        );
//
//        $this->table = (new AirtableClient($config, getenv('TEST_BASE_ID')))
//            ->getTable(getenv('TEST_TABLE_NAME'));
    }

    public function testThatConstructorSetsInternalPropertyAndGetterReturnsSame(): void
    {
        $tableNameProperty = new \ReflectionProperty(Table::class, 'tableName');
        $tableNameProperty->setAccessible(true);

        $testTableName = sha1(random_bytes(10));
        $table = new Table($testTableName);

        $this->assertSame($testTableName, $tableNameProperty->getValue($table));
        $this->assertSame($testTableName, $table->getName());
    }
}
