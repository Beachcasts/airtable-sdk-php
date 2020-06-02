<?php

declare(strict_types=1);

namespace Beachcasts\AirtableTests\Unit;

use Assert\InvalidArgumentException;
use Beachcasts\Airtable\Config;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use TypeError;

class ConfigTest extends TestCase
{

    /**
     * @var ReflectionProperty
     */
    private $baseUrlProperty;

    /**
     * @var ReflectionProperty
     */
    private $versionProperty;

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

        $this->apiKeyProperty = new ReflectionProperty(Config::class, 'apiKey');
        $this->apiKeyProperty->setAccessible(true);
    }

    /**
     * @runInSeparateProcess
     */
    public function testThatFromEnvironmentFailsWhenNoEnvironSet(): void
    {
        putenv('AIRTABLE_BASE_URL');
        putenv('AIRTABLE_API_VERSION');
        putenv('AIRTABLE_API_KEY');
        $this->expectException(TypeError::class);
        Config::fromEnvironment();
    }

    /**
     * @runInSeparateProcess
     */
    public function testThatFromEnvironmentSetsInternalWhenEnvironSet(): void
    {
        $baseUrl = 'https://' . sha1(random_bytes(10)) . '.com';
        $version = 'v' . random_int(11, 99);
        $apiKey = sha1(random_bytes(10));

        //put our values into ENV
        putenv('AIRTABLE_BASE_URL=' . $baseUrl);
        putenv('AIRTABLE_API_VERSION=' . $version);
        putenv('AIRTABLE_API_KEY=' . $apiKey);

        $config = Config::fromEnvironment();

        //clean up
        putenv('AIRTABLE_BASE_URL');
        putenv('AIRTABLE_API_VERSION');
        putenv('AIRTABLE_API_KEY');

        self::assertSame($baseUrl, $this->baseUrlProperty->getValue($config));
        self::assertSame($baseUrl, $config->getBaseUrl());
        self::assertSame($version, $this->versionProperty->getValue($config));
        self::assertSame($version, $config->getVersion());
        self::assertSame($apiKey, $this->apiKeyProperty->getValue($config));
        self::assertSame($apiKey, $config->getApiKey());
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

        Config::fromValues($values['baseUrl'], $values['version'], $values['apiKey']);
    }

    public function testThatGettersReturnExpectedValues(): void
    {
        $config = Config::fromValues(
            'https://baseUrl.test',
            'v0',
            'apiKey'
        );

        $randomValue = sha1(random_bytes(10));
        $this->baseUrlProperty->setValue($config, $randomValue);
        $this->assertSame($randomValue, $config->getBaseUrl());

        $randomValue = sha1(random_bytes(10));
        $this->versionProperty->setValue($config, $randomValue);
        $this->assertSame($randomValue, $config->getVersion());

        $randomValue = sha1(random_bytes(10));
        $this->apiKeyProperty->setValue($config, $randomValue);
        $this->assertSame($randomValue, $config->getApiKey());
    }
}
