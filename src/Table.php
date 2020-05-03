<?php
/**
 * Project airtable-sdk-php
 * File: Table.php
 * Created by: tpojka
 * On: 26/03/2020
 */

declare(strict_types=1);

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
     *
     * Params could include the following:
     *      fields = ['column_1_name', 'column_2_name', 'column_3_name]
     *      filterByFormula = "NOT({Headline} = '')"
     *      maxRecords = 100
     *      pageSize = 100
     *      sort = [{field: "Headline", direction: "desc"}]
     *      view = "view_name"
     *
     * @param array $params
     * @return ResponseInterface
     */
    public function list(array $params = []): ResponseInterface
    {
//        if (!empty($params)) $qsa = http_build_query($params) #as query string append
        $url = $this->name . '?maxRecords=3&view=' . $this->viewName;

        return $this->client->request(
            'GET',
            $url,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . getenv('API_KEY'),
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
                    'Authorization' => 'Bearer ' . getenv('API_KEY'),
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
            $this->name . '/' . $id,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . getenv('API_KEY'),
                ],
            ]
        );
    }

    /**
     * @param string $data
     * @param string $type accepts PUT to replace or PATCH to update records
     * @return mixed
     * @throws \Exception
     */
    public function update(string $data, $type = 'PATCH')
    {
        if (!in_array(strtolower($type), ['put', 'patch'])) {
            throw new \Exception('Invalid method type.');
        }

        return $this->client->request(
            strtoupper($type),
            $this->name,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . getenv('API_KEY'),
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
                    'Authorization' => 'Bearer ' . getenv('API_KEY'),
                ],
                'query' => ['records[]' => $id],
            ]
        );
    }
}
