<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

use Assert\Assert;

class Config
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $apiKey;

    protected function __construct(string $baseUrl, string $version, string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->version = $version;
        $this->apiKey = $apiKey;
    }

    public static function fromEnvironment(): Config
    {
        $baseUrl = getenv('BASE_URL');
        $version = getenv('VERSION');
        $apiKey = getenv('API_KEY');

        self::validateValues($baseUrl, $version, $apiKey);

        return new self($baseUrl, $version, $apiKey);
    }

    public static function fromValues(string $baseUrl, string $version, string $apiKey): Config
    {
        self::validateValues($baseUrl, $version, $apiKey);

        return new self($baseUrl, $version, $apiKey);
    }

    protected static function validateValues(string $baseUrl, string $version, string $apiKey): bool
    {
        Assert::that($baseUrl)
            ->notBlank('baseUrl was blank/empty')
            ->url('baseUrl was not a valid url');

        Assert::that($version)
            ->regex('/v\d+/', 'Version did not match expected pattern');

        Assert::that($apiKey)
            ->notBlank('apiKey was blank/empty');

        return true;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
