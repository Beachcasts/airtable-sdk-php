<?php

declare(strict_types=1);

namespace Beachcasts\AirtableTests;

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
    protected $data;
    protected $table;

    protected function setUp(): void
    {
        Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR)->load();
        $this->config = Config::fromEnvironment();
        $this->table = new Table(getenv('TEST_TABLE_NAME'));

        $airtableClient = new AirtableClient($this->config, getenv('TEST_BASE_ID'));
        $this->table->setClient($airtableClient->getClient());

        $this->data = [
            'records' => [
                [
                    'fields' => [
                        'Name' => 'Name Test',
                        'Notes' => 'This is a test from the suite',
                    ],
                ],
            ],
        ];
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

    public function testCreateRecord(): array
    {
        $response = $this->table->create($this->data['records']);

        $result = json_decode((string)$response->getBody(), true);

        $this->assertEquals(
            '200',
            $response->getStatusCode(),
            'API did not return HTTP 200'
        );


        $this->assertEquals(
            'Name Test',
            $result['records'][0]['fields']['Name'],
            'Record did not contain the correct Name.'
        );

        return $result;
    }

    /**
     * @depends testCreateRecord
     * @param array $record
     */
    public function testListRecords(array $record): void
    {
        $params = [
            'maxRecords' => 3
        ];

        $response = $this->table->list($params);
        $result = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('records', $result);

        $this->assertContains($record['records'][0], $result['records']);
    }

    /**
     * @depends testCreateRecord
     * @param array $record
     */
    public function testReadRecord(array $record): void
    {
        $response = $this->table->read($record['records'][0]['id']);

        $result = json_decode((string)$response->getBody(), true);

        $this->assertSame($result, $record['records'][0]);
    }

    /**
     * @depends testCreateRecord
     * @param array $record
     */
    public function testUpdateWrongTypePassed(array $record): void
    {
        $this->data = $record;
        unset($this->data['records'][0]['createdTime']);

        $this->expectException(\Exception::class);

        $this->table->update($this->data['records'], 'GET');
    }

    /**
     * @depends testCreateRecord
     * @param array $record
     * @return array
     * @throws \Exception
     */
    public function testUpdateRecord(array $record): array
    {
        $newName = 'New Name Test';

        $this->data['records'][0]['id'] = $record['records'][0]['id'];
        $this->data['records'][0]['fields']['Name'] = $newName;

        $response = $this->table->update($this->data['records']);

        $result = json_decode((string)$response->getBody(), true);

        $this->assertEquals(
            '200',
            $response->getStatusCode(),
            'API did not return HTTP 200'
        );

        $this->assertEquals(
            $newName,
            $result['records'][0]['fields']['Name'],
            'Record did not contain the correct Name.'
        );

        return $result;
    }

    /**
     * @depends testUpdateRecord
     * @param array $record
     * @return array
     * @throws \Exception
     */
    public function testReplaceRecord(array $record): array
    {
        $newName = 'Another New Name Test';

        $this->data = $record;
        $this->data['records'][0]['fields']['Name'] = $newName;
        unset($this->data['records'][0]['createdTime']);

        $response = $this->table->update($this->data['records'], "PUT");

        $result = json_decode((string)$response->getBody(), true);

        $this->assertEquals(
            '200',
            $response->getStatusCode(),
            'API did not return HTTP 200'
        );

        $this->assertEquals(
            $newName,
            $result['records'][0]['fields']['Name'],
            'Record did not contain the correct Name.'
        );

        return $result;
    }

    /**
     * @depends testReplaceRecord
     * @param array $record
     */
    public function testDeleteRecord(array $record): void
    {
        $response = $this->table->delete($record['records'][0]['id']);

        $result = json_decode((string)$response->getBody(), true);

        $this->assertEquals(
            '200',
            $response->getStatusCode(),
            'API did not return HTTP 200'
        );

        $this->assertTrue($result['records'][0]['deleted']);
    }
}
