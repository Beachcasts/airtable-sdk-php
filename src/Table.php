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
    protected $name = null;

    protected $client;

    protected $viewName;

    /**
     * Table constructor.
     *
     * @param string $name
     * @param string $viewName
     */
    public function __construct(string $name, string $viewName = "Grid view")
    {
        $this->name = $name;
        $this->viewName = $viewName;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ResponseInterface
     */
    public function list(): ResponseInterface
    {
        return $this->client->request(
            'GET',
            $this->name . '?maxRecords=3&view=' . $this->viewName,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['API_KEY'],
                ]
            ]
        );
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function create(string $data)
    {
        return $this->client->request(
            'POST',
            $this->name,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['API_KEY'],
                    'Content-Type' => 'application/json',
                ],
                'body' => $data,
            ]
        );
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function read(string $id)
    {
        return $this->client->request(
            'GET',
            $this->name . DIRECTORY_SEPARATOR . $id,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['API_KEY'],
                ],
            ]
        );
    }

    /**
     * @param $data
     * @return mixed
     */
    public function update(string $data)
    {
        return $this->client->request(
            'PATCH',
            $this->name,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['API_KEY'],
                    'Content-Type' => 'application/json',
                ],
                'body' => $data,
            ]
        );
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id)
    {
        return $this->client->request(
            'DELETE',
            $this->name,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['API_KEY'],
                ],
                'query' => ['records[]' => $id],
            ]
        );
    }
}
