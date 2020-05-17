<?php

declare(strict_types=1);

namespace Beachcasts\Airtable\Request;

use Assert\Assert;
use GuzzleHttp\Psr7\Request;

class TableRequest extends Request
{
    public static function createRecords(string $tableName, array $records): Request
    {
        Assert::thatAll($records)
            ->keyExists('fields');

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

    public static function updateRecords(string $tableName, array $records, string $type): Request
    {
        Assert::thatAll($records)
            ->keyExists('fields');

        return new self(
            $type,
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
