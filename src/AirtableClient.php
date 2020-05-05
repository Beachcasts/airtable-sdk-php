<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

use GuzzleHttp\Client;

/**
 * Class AirtableClient
 * @package Beachcasts\Airtable
 */
class AirtableClient
{
    /**
     * Base identifier
     *
     * @var null
     */
    protected $baseId = null;

    /**
     * Guzzle client object
     *
     * @var Client|null
     */
    protected $client = null;

    /**
     * @var Table|null
     */
    protected $table = null;

    /**
     * Airtable constructor. Create a new Airtable Instance
     *
     * @param string $baseId
     */
    public function __construct(string $baseId)
    {
        $this->client = new Client([
            'base_uri' => getenv('BASE_URL') . '/' . getenv('VERSION') . '/' . $baseId . '/'
        ]);

        $this->baseId = $baseId;
    }

    /**
     * @return Client|null
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}
