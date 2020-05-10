<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

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

        if (!self::validateValues($baseUrl, $version, $apiKey, $baseId)) {
            throw new \InvalidArgumentException();
        }

        return new self($baseUrl, $version, $apiKey, $baseId);
    }

    public static function fromValues(string $baseUrl, string $version, string $apiKey, string $baseId): Config
    {
        if (!self::validateValues($baseUrl, $version, $apiKey, $baseId)) {
            throw new \InvalidArgumentException();
        }

        return new self($baseUrl, $version, $apiKey, $baseId);
    }

    protected static function validateValues(string $baseUrl, string $version, string $apiKey, string $baseId): bool
    {
        // validate
        return true; // false
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
