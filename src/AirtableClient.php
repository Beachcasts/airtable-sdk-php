<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

use GuzzleHttp\Client;

class AirtableClient
{
    /**
     * Airtable's API base URL
     */
    private const BASE_URL = 'https://api.airtable.com';

    /**
     * Airtable's API version
     */
    private const VERSION = 'v0';

    /**
     * Airtable's API_KEY
     *
     * @var string|null
     */
    private $token = null;

    /**
     * Base identifier
     *
     * @var null
     */
    private $baseId = null;

    /**
     * Guzzle client object
     *
     * @var Client|null
     */
    private $client = null;

    /**
     * Airtable constructor. Create a new Airtable Instance
     *
     * @param string $token
     * @param string $baseId
     * @param Table $table
     */
    public function __construct(string $token, string $baseId, Table $table)
    {
        $this->token = $token;
        $this->baseId = $baseId;
        $this->client = new Client();
        $this->client->request('GET', self::BASE_URL . DIRECTORY_SEPARATOR . self::VERSION . DIRECTORY_SEPARATOR . $baseId . DIRECTORY_SEPARATOR . $table->name , ['headers' => [
            'Authorization' => 'Bearer ' . $token,
        ]]);
    }
}
