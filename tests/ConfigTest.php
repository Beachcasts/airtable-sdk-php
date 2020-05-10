<?php

namespace Beachcasts\AirtableTests;

use Assert\InvalidArgumentException;
use Beachcasts\Airtable\Config;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use TypeError;

class ConfigTest extends TestCase
{

    private $baseUrlProperty;
    /**
     * @var ReflectionProperty
     */
    private $versionProperty;
    /**
     * @var ReflectionProperty
     */
    private $baseIdProperty;
    /**
     * @var ReflectionProperty
     */
    private $apiKeyProperty;

    protected function setUp(): void
    {
        $this->baseUrlProperty = new ReflectionProperty(Config::class, 'baseUrl');
        $this->baseUrlProperty->setAccessible(true);

        $this->versionProperty = new ReflectionProperty(Config::class, 'version');
        $this->versionProperty->setAccessible(true);

        $this->baseIdProperty = new ReflectionProperty(Config::class, 'baseId');
        $this->baseIdProperty->setAccessible(true);

        $this->apiKeyProperty = new ReflectionProperty(Config::class, 'apiKey');
        $this->apiKeyProperty->setAccessible(true);
    }

    public function testThatFromEnvironmentFailsWhenNoEnvironSet(): void
    {
        $this->expectException(TypeError::class);
        Config::fromEnvironment();
    }

    public function testThatFromEnvironmentSetsInternalWhenEnvironSet(): void
    {
        Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR)->load();

        $config = Config::fromEnvironment();

        self::assertSame(getenv('BASE_URL'), $this->baseUrlProperty->getValue($config));
        self::assertSame(getenv('VERSION'), $this->versionProperty->getValue($config));
        self::assertSame(getenv('API_KEY'), $this->apiKeyProperty->getValue($config));
        self::assertSame(getenv('BASE_ID'), $this->baseIdProperty->getValue($config));
    }

    public function invalidValuesForValidation(): array
    {
        return [
            'baseUrl empty string' => [
                'values' => ['baseUrl' => '', 'version' => '', 'apiKey' => '', 'baseId' => '',],
                'exceptionMessage' => 'baseUrl was blank/empty'
            ],
            'baseUrl not URL' => [
                'values' => ['baseUrl' => 'not url', 'version' => '', 'apiKey' => '', 'baseId' => '',],
                'exceptionMessage' => 'baseUrl was not a valid url'
            ],
            'version pattern fail' => [
                'values' => ['baseUrl' => 'http://google.com', 'version' => 'dfdfdf', 'apiKey' => '', 'baseId' => '',],
                'exceptionMessage' => 'Version did not match expected pattern'
            ],
            'apiKey empty string' => [
                'values' => ['baseUrl' => 'http://google.com', 'version' => 'v0', 'apiKey' => '', 'baseId' => '',],
                'exceptionMessage' => 'apiKey was blank/empty'
            ],
            'baseId empty string' => [
                'values' => [
                    'baseUrl' => 'http://google.com',
                    'version' => 'v0',
                    'apiKey' => 'fakekey',
                    'baseId' => '',
                ],
                'exceptionMessage' => 'baseId was blank/empty'
            ],
        ];
    }

    /**
     * @dataProvider invalidValuesForValidation
     * @param array $values
     * @param string $exceptionMessage
     */
    public function testThatFromValuesFailsValidation(array $values, string $exceptionMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);

        Config::fromValues($values['baseUrl'], $values['version'], $values['apiKey'], $values['baseId']);
    }

    public function testThatGettersReturnExpectedValues(): void
    {
        Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR)->load();
        $config = Config::fromEnvironment();
        $randomValue = sha1(random_bytes(10));
        $this->baseUrlProperty->setValue($config, $randomValue);
        $this->assertSame($randomValue, $config->getBaseUrl());

        $randomValue = sha1(random_bytes(10));
        $this->baseIdProperty->setValue($config, $randomValue);
        $this->assertSame($randomValue, $config->getBaseId());

        $randomValue = sha1(random_bytes(10));
        $this->versionProperty->setValue($config, $randomValue);
        $this->assertSame($randomValue, $config->getVersion());

        $randomValue = sha1(random_bytes(10));
        $this->apiKeyProperty->setValue($config, $randomValue);
        $this->assertSame($randomValue, $config->getApiKey());
    }
}
