<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

use Dotenv\Dotenv;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;

class AirtableClientTest extends TestCase
{
    protected function setUp() : void
    {
        Dotenv::create(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR)->load();
    }

    public function testThatCreationSetsUpClient() : void
    {
        $randomId = sha1(random_bytes(10));
        $client   = new AirtableClient($randomId);

        $property = new \ReflectionProperty(AirtableClient::class, 'client');
        $property->setAccessible(true);

        self::assertInstanceOf(GuzzleHttpClient::class, $property->getValue($client));
        self::assertSame($property->getValue($client), $client->getClient());
        /** @var Uri $uri */
        $uri = $client->getClient()->getConfig('base_uri');
        self::assertStringContainsString($randomId, $uri->getPath());
    }

    public function testThatGetTableReturnsCorrectlyConfiguredTableObject(): void
    {
        $randomId = sha1(random_bytes(10));
        $client   = new AirtableClient($randomId);

        $tableName = sha1(random_bytes(10));
        $viewMode = sha1(random_bytes(10));
        $result = $client->getTable($tableName, $viewMode);

        $tableNameProperty = new \ReflectionProperty(Table::class, 'tableName');
        $tableNameProperty->setAccessible(true);

        self::assertSame($tableName, $tableNameProperty->getValue($result));
        self::assertSame($tableName, $result->getName());
    }
}
