<?php
/**
 * Project airtable-sdk-php
 * File: Table.php
 * Created by: tpojka
 * On: 26/03/2020
 */

namespace Beachcasts\Airtable;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Table
 * @package Beachcasts\Airtable
 */
class Table
{
    /**
     * @var string|null
     */
    public $name = null;

    /**
     * Table constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param Client $connection
     * @param string $view
     * @return ResponseInterface
     */
    public function list(Client $connection, string $view = "Grid view"): ResponseInterface
    {
        $list = $connection->request(
            'GET',
            $this->name . '?maxRecords=3&view=' . $view,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['API_KEY'],
                ]
            ]
        );

        return $list;
    }
}
