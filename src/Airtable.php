<?php

declare(strict_types=1);

namespace Beachcasts\Airtable;

use GuzzleHttp\Client;

class Airtable
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
     */
    public function __construct(string $token, string $baseId)
    {
        $this->token = $token;
        $this->client = new Client();
        $response = $this->client->request('GET', self::BASE_URL . DIRECTORY_SEPARATOR . self::VERSION . DIRECTORY_SEPARATOR . $baseId, ['headers' => [
            'Authorization' => 'Bearer ' . $token,
        ]]);
    }
}
