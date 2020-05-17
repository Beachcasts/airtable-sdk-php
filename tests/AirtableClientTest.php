<?php

declare(strict_types=1);

namespace Beachcasts\AirtableTests;

use Assert\InvalidArgumentException;
use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;
use Beachcasts\Airtable\Middleware\BearerTokenMiddleware;
use Beachcasts\Airtable\Table;
use Dotenv\Dotenv;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;

class AirtableClientTest extends TestCase
{
    /**
     * @var AirtableClient
     */
    private $airtableClient;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $baseId;

    protected function setUp(): void
    {
        Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR)->load();

        $this->config = Config::fromValues(
            'https://google.com',
            'v0',
            sha1(random_bytes(10))
        );
        $this->baseId = sha1(random_bytes(10));

        $this->airtableClient = new AirtableClient($this->config, $this->baseId);
    }

    public function testThatPassingEmptyBaseIdTriggersException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('AirTable requires a non-empty $baseId');
        new AirtableClient($this->config, '');
    }

    public function testThatCreationSetsUpClient(): void
    {
        $property = new \ReflectionProperty(AirtableClient::class, 'client');
        $property->setAccessible(true);
        $guzzleClient = $this->airtableClient->getClient();

        self::assertInstanceOf(GuzzleHttpClient::class, $property->getValue($this->airtableClient));
        self::assertSame($property->getValue($this->airtableClient), $guzzleClient);
        self::assertSame(
            sprintf(
                '%s/%s/%s/',
                $this->config->getBaseUrl(),
                $this->config->getVersion(),
                $this->baseId
            ),
            $guzzleClient->getConfig('base_uri')->__toString()
        );
    }

    public function testThatBearerTokenMiddlewareIsRegistered(): void
    {
        $stackProperty = new \ReflectionProperty(HandlerStack::class, 'stack');
        $stackProperty->setAccessible(true);

        $stackValue = $stackProperty->getValue($this->airtableClient->getClient()->getConfig('handler'));
        $names = array_column($stackValue, 1);
        self::assertContains(BearerTokenMiddleware::class, $names);
    }

    public function testThatGetTableReturnsCorrectlyConfiguredTableObject(): void
    {
        $tableName = sha1(random_bytes(10));
        $result = $this->airtableClient->getTable($tableName);

        $tableNameProperty = new \ReflectionProperty(Table::class, 'tableName');
        $tableNameProperty->setAccessible(true);

        self::assertSame($tableName, $tableNameProperty->getValue($result));
        self::assertSame($tableName, $result->getName());
    }
}
