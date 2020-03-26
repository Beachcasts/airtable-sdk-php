<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

use GuzzleHttp\Client;

class AirtableClient
{
    private const BASE_URL = 'https://api.airtable.com';

    private const VERSION = 'v0';

    private $token = null;

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
        $this->client = new Client();
        $response = $this->client->request('GET', self::BASE_URL . DIRECTORY_SEPARATOR . self::VERSION . DIRECTORY_SEPARATOR . $baseId . DIRECTORY_SEPARATOR . $table->name , ['headers' => [
            'Authorization' => 'Bearer ' . $token,
        ]]);
    }
}
