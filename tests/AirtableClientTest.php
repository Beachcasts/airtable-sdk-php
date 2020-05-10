<?php

declare(strict_types=1);

namespace Beachcasts\AirtableTests;

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;
use Beachcasts\Airtable\Middleware\BearerTokenMiddleware;
use Beachcasts\Airtable\Table;
use Dotenv\Dotenv;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;

class AirtableClientTest extends TestCase
{
    /**
     * @var AirtableClient
     */
    private $client;
    /**
     * @var Config
     */
    private $config;

    protected function setUp(): void
    {
        Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR)->load();

        $this->config = Config::fromValues(
            'https://google.com',
            'v0',
            sha1(random_bytes(10)),
            sha1(random_bytes(10))
        );
        $this->client = new AirtableClient($this->config);
    }

    public function testThatCreationSetsUpClient(): void
    {
        $property = new \ReflectionProperty(AirtableClient::class, 'client');
        $property->setAccessible(true);

        self::assertInstanceOf(GuzzleHttpClient::class, $property->getValue($this->client));
        self::assertSame($property->getValue($this->client), $this->client->getClient());
        /** @var Uri $uri */
        $uri = $this->client->getClient()->getConfig('base_uri');
        self::assertStringContainsString($this->config->getBaseId(), $uri->getPath());
    }

    public function testThatBearerTokenMiddlewareIsRegistered(): void
    {
        $stackProperty = new \ReflectionProperty(HandlerStack::class, 'stack');
        $stackProperty->setAccessible(true);

        $stackValue = $stackProperty->getValue($this->client->getClient()->getConfig('handler'));
        $names = array_column($stackValue, 1);
        self::assertContains(BearerTokenMiddleware::class, $names);
    }

    public function testThatGetTableReturnsCorrectlyConfiguredTableObject(): void
    {
        $tableName = sha1(random_bytes(10));
        $viewMode = sha1(random_bytes(10));
        $result = $this->client->getTable($tableName, $viewMode);

        $tableNameProperty = new \ReflectionProperty(Table::class, 'tableName');
        $tableNameProperty->setAccessible(true);

        self::assertSame($tableName, $tableNameProperty->getValue($result));
        self::assertSame($tableName, $result->getName());
    }
}
