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

        $airtableClient = new AirtableClient(getenv('TEST_BASE_ID'));
        $client = $airtableClient->getClient();

        $this->table = new Table(getenv('TEST_TABLE_NAME'), getenv('TEST_VIEW_NAME'));
        $this->table->setClient($client);

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

    public function testCreateRecord()
    {
        $response = $this->table->create(json_encode($this->data));

        $result = json_decode((string) $response->getBody(), true);

        $this->assertTrue(
            $response->getStatusCode() == '200',
            'API did not return HTTP 200'
        );

        $this->assertTrue(
            $result['records'][0]['fields']['Name'] == 'Name Test',
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
        $recordId = $result['records'][0]['id'];


        // @todo this method not finished
//        print_r($result);

        $this->assertTrue(true);
    }
}
