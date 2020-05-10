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
    private $baseId;
    /**
     * @var string
     */
    private $apiKey;

    protected function __construct(string $baseUrl, string $version, string $apiKey, string $baseId)
    {
        $this->baseUrl = $baseUrl;
        $this->version = $version;
        $this->baseId = $baseId;
        $this->apiKey = $apiKey;
    }

    public static function fromEnvironment(): Config
    {
        $baseUrl = getenv('BASE_URL');
        $version = getenv('VERSION');
        $apiKey = getenv('API_KEY');
        $baseId = getenv('BASE_ID');

        self::validateValues($baseUrl, $version, $apiKey, $baseId);

        return new self($baseUrl, $version, $apiKey, $baseId);
    }

    public static function fromValues(string $baseUrl, string $version, string $apiKey, string $baseId): Config
    {
        self::validateValues($baseUrl, $version, $apiKey, $baseId);

        return new self($baseUrl, $version, $apiKey, $baseId);
    }

    protected static function validateValues(string $baseUrl, string $version, string $apiKey, string $baseId): bool
    {
        Assert::that($baseUrl)
            ->notBlank('baseUrl was blank/empty')
            ->url('baseUrl was not a valid url');

        Assert::that($version)
            ->regex('/v\d+/', 'Version did not match expected pattern');

        Assert::that($apiKey)
            ->notBlank('apiKey was blank/empty');

        Assert::that($baseId)
            ->notBlank('baseId was blank/empty');

        // validate
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

    public function getBaseId(): string
    {
        return $this->baseId;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
