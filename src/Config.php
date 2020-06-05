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

    public static function fromEnvironment(): self
    {
        $baseUrl = getenv('AIRTABLE_BASE_URL');
        $version = getenv('AIRTABLE_API_VERSION');
        $apiKey = getenv('AIRTABLE_API_KEY');

        return self::fromValues($baseUrl, $version, $apiKey);
    }

    public static function fromValues(string $baseUrl, string $version, string $apiKey): self
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
