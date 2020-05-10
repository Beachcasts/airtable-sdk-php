<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

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
     * @var Config
     */
    private $config;

    /**
     * Airtable constructor. Create a new Airtable Instance
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->client = new Client(
            [
                'base_uri' => $config->getBaseUrl() . '/' . $config->getVersion() . '/' . $config->getBaseId() . '/',
                'handler' => $this->getBearerTokenStack($config->getApiKey())
            ]
        );

        $this->config = $config;
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

    public function getTable(string $tableName, string $viewName = "Grid view"): Table
    {
        $table = new Table($tableName, $viewName);
        $table->setClient($this->client);

        return $table;
    }
}
