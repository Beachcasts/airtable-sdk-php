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
    protected $response;
    protected $result;

    protected function setUp(): void
    {
        Dotenv::create(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR)->load();

        $this->table = new Table($_ENV['TEST_TABLE_NAME'], $_ENV['TEST_VIEW_NAME']);

        $airtableClient = new AirtableClient($_ENV['TEST_BASE_ID'], $this->table);
        $client = $airtableClient->getClient();

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

        $this->result = json_decode((string) $response->getBody(), true);

        $this->assertTrue(
            $response->getStatusCode() == '200',
            'API did not return HTTP 200'
        );

        $this->assertTrue(
            $this->result['records'][0]['fields']['Name'] == 'Name Test',
            'Record did not contain the correct Name.'
        );
    }
}
