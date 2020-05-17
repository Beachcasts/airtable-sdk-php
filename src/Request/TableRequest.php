<?php

declare(strict_types=1);

namespace Beachcasts\Airtable\Request;

use Assert\Assert;
use GuzzleHttp\Psr7\Request;

class TableRequest extends Request
{
    public static function createRecords(string $tableName, array $records): Request
    {
        Assert::that($tableName)
            ->notEmpty('Table name must not be empty');

        Assert::that($records)
            ->notEmpty('Records must not be empty');

        // we want to make sure we don't pass a k-v array, but numeric indexed
        // as api expects records to be of
        $records = array_values($records);

        foreach ($records as $idx => &$record) {
            Assert::that($record)
                ->keyExists('fields', sprintf('Record[%d] should contain a "fields" entry', $idx));

            Assert::that($record['fields'])
                ->isArray(sprintf('Record[%d] "fields" should be Array', $idx));

            if (empty($record['fields'])) {
                $record['fields'] = new \stdClass(); // API requires fields to be object
            } else {
                Assert::thatAll(array_keys($record['fields']))
                    ->string('All "fields" must be string-keyed');
            }
        }

        return new self(
            'POST',
            $tableName,
            [
                'Content-Type' => 'application/json',
            ],
            json_encode(
                [
                    'records' => $records
                ]
            )
        );
    }

    public static function readRecords(string $tableName, string $recordId): Request
    {
        Assert::that($tableName)
            ->notEmpty('Table name must not be empty');
        Assert::that($recordId)
            ->notEmpty('Record Id must not be empty');

        return new self(
            'GET',
            $tableName . '/' . $recordId
        );
    }

    public static function updateRecords(string $tableName, array $records, string $type): Request
    {
        Assert::that($tableName)
            ->notEmpty();
        Assert::thatAll($records)
            ->keyExists('fields')
            ->keyExists('id');
        Assert::that(strtoupper($type))
            ->inArray(['PUT', 'PATCH']);

        return new self(
            strtoupper($type),
            $tableName,
            [
                'Content-Type' => 'application/json',
            ],
            json_encode(
                [
                    'records' => $records
                ]
            )
        );
    }
}
