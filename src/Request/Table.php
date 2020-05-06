<?php

declare(strict_types=1);

namespace Beachcasts\Airtable\Request;

use Assert\Assert;
use Beachcasts\Airtable\Request;

class Table extends Request
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
}
