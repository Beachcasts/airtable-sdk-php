<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

use Assert\Assert;
use Beachcasts\Airtable\Middleware\BearerTokenMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

/**
 * Class AirtableClient
 * @package Beachcasts\Airtable
 */
class AirtableClient
{
    /**
     * Guzzle client object
     *
     * @var Client|null
     */
    protected $client;

    /**
     * Airtable constructor. Create a new Airtable Instance
     *
     * @param Config $config
     * @param string $baseId
     */
    public function __construct(Config $config, string $baseId)
    {
        Assert::that($baseId)
            ->notBlank('AirTable requires a non-empty $baseId');

        $this->client = new Client(
            [
                'base_uri' => $config->getBaseUrl() . '/' . $config->getVersion() . '/' . $baseId . '/',
                'handler' => $this->getBearerTokenStack($config->getApiKey())
            ]
        );
    }

    private function getBearerTokenStack(string $apiKey): HandlerStack
    {
        $stack = new HandlerStack(new CurlHandler());
        $stack->push(Middleware::mapRequest(new BearerTokenMiddleware($apiKey)), BearerTokenMiddleware::class);

        return $stack;
    }

    /**
     * @return Client|null
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function getTable(string $tableName): Table
    {
        $table = new Table($tableName);
        $table->setClient($this->client);

        return $table;
    }
}
