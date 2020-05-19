<?php
/**
 * Project airtable-sdk-php
 * File: Table.php
 * Created by: tpojka
 * On: 26/03/2020
 */

declare(strict_types=1);

namespace Beachcasts\Airtable;

use Beachcasts\Airtable\Request\TableRequest as TableRequest;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Table
 * @package Beachcasts\Airtable
 */
class Table
{
    /**
     * @var string|null $tableName
     */
    protected $tableName;

    /**
     * @var Client $client
     */
    protected $client;

    /**
     * Table constructor.
     *
     * @param string $tableName
     */
    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->tableName;
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
    public function list(array $params): ResponseInterface
    {
//        if (!empty($params))
        $queryString = http_build_query($params);

        $url = $this->tableName . '?' . $queryString;

        return $this->client->request('GET', $url);
    }

    /**
     * @param array $records
     * @return mixed
     */
    public function create(array $records)
    {
        return $this->client->send(
            TableRequest::createRecords($this->getName(), $records)
        );
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function read(string $id)
    {
        return $this->client->send(
            TableRequest::readRecords($this->tableName, $id)
        );
    }

    /**
     * @param array $records
     * @param string $type accepts PUT to replace or PATCH to update records
     * @return mixed
     * @throws \Exception
     * @todo split out to a replace method for PUT
     *
     */
    public function update(array $records, $type = 'PATCH')
    {
        return $this->client->send(
            TableRequest::updateRecords($this->getName(), $records, $type)
        );
    }

    /**
     * @param string $recordId
     * @return mixed
     */
    public function delete(string $recordId)
    {
        return $this->client->send(
            TableRequest::deleteRecords($this->getName(), $recordId)
        );
    }
}
