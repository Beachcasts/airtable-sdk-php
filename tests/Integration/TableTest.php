<?php

declare(strict_types=1);

namespace Beachcasts\AirtableTests\Integration;

use Beachcasts\Airtable\AirtableClient as AirtableClient;
use Beachcasts\Airtable\Config;
use Beachcasts\Airtable\Table;
use Dotenv\Dotenv;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    /**
     * @var array $apiData
     */
    private $apiData = [];

    /**
     * @var Table
     */
    private $table;

    protected function setUp(): void
    {
        Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR)->load();
        $config = Config::fromEnvironment();
        $this->table = (new AirtableClient($config, getenv('TEST_BASE_ID')))
            ->getTable(getenv('TEST_TABLE_NAME'));

        $this->apiData = [
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

    public function testCreateRecord(): array
    {
        $response = $this->table->create($this->apiData['records']);

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
        $recordId = $record['records'][0]['id'];
        $response = $this->table->read($recordId);

        $result = json_decode((string)$response->getBody(), true);

        $this->assertSame($result, $record['records'][0]);
    }

    /**
     * @depends testCreateRecord
     * @param array $record
     */
    public function testUpdateWrongTypePassed(array $record): void
    {
        $this->apiData = $record;
        unset($this->apiData['records'][0]['createdTime']);

        $this->expectException(\Exception::class);

        $this->table->update($this->apiData['records'], 'GET');
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

        $this->apiData['records'][0]['id'] = $record['records'][0]['id'];
        $this->apiData['records'][0]['fields']['Name'] = $newName;

        $response = $this->table->update($this->apiData['records']);

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

        $this->apiData = $record;
        $this->apiData['records'][0]['fields']['Name'] = $newName;
        unset($this->apiData['records'][0]['createdTime']);

        $response = $this->table->update($this->apiData['records'], "PUT");

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

    /**
     * @depends testDeleteRecord
     *
     * This tests that when we pass an empty fields array, that it gets converted correctly to object
     *    which the API requires.
     */
    public function testThatCreateRecordAllowsEmptyFields(): void
    {
        /** @var Response $response */
        $response = $this->table->create([['fields' => []]]);

        $this->assertEquals(
            '200',
            $response->getStatusCode(),
            'API did not return HTTP 200'
        );

        $result = json_decode((string)$response->getBody(), true);
        $this->table->delete($result['records']['0']['id']);
    }
}
