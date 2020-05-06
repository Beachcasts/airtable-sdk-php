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
     * Base identifier
     *
     * @var null|string $baseId
     */
    protected $baseId;

    /**
     * Guzzle client object
     *
     * @var Client|null
     */
    protected $client;

    /**
     * Airtable constructor. Create a new Airtable Instance
     *
     * @param string $apiKey
     * @param string $baseId
     */
    public function __construct(string $apiKey, string $baseId)
    {
        $this->client = new Client(
            [
                'base_uri' => getenv('BASE_URL') . '/' . getenv('VERSION') . '/' . $baseId . '/',
                'handler' => $this->getBearerTokenStack($apiKey)
            ]
        );

        $this->baseId = $baseId;
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
