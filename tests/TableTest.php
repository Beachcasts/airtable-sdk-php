<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

use PHPUnit\Framework\TestCase;
use Beachcasts\Airtable\Table as Table;
use Beachcasts\Airtable\AirtableClient as AirtableClient;
use Dotenv\Dotenv;

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
        Dotenv::create(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR)->load();

        $this->table = new Table(getenv('TEST_TABLE_NAME'), getenv('TEST_VIEW_NAME'));

        $airtableClient = new AirtableClient(getenv('TEST_BASE_ID'));
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

    public function testCreateRecord() : array
    {
        $response = $this->table->create($this->data['records']);

        $result = json_decode((string) $response->getBody(), true);

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
     * @param array $result
     */
    public function testUpdateRecord(array $result)
    {
//        $recordId = $result['records'][0]['id'];

        $this->assertTrue(true);
    }
}
