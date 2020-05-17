<?php

namespace Beachcasts\AirtableTests\Request;

use Assert\InvalidArgumentException;
use Beachcasts\Airtable\Request\TableRequest;
use PHPUnit\Framework\TestCase;

class TableRequestTest extends TestCase
{
    public function badCreateDataProvider(): array
    {
        return [
            'Table name must not be empty' => [
                'tableName' => '',
                'records' => [],
                'message' => 'Table name must not be empty'
            ],
            'Records must not be empty' => [
                'tableName' => 'table name',
                'records' => [],
                'message' => 'Records must not be empty'
            ],
            'Records must have fields' => [
                'tableName' => 'table name',
                'records' => [
                    [],
                ],
                'message' => 'Record[0] should contain a "fields" entry'
            ],
            'Records fields should be an array' => [
                'tableName' => 'table name',
                'records' => [
                    [
                        'fields' => ''
                    ],
                ],
                'message' => 'Record[0] "fields" should be Array'
            ],
            'Records fields should be an array - different index' => [
                'tableName' => 'table name',
                'records' => [
                    [
                        'fields' => [
                            'Name' => 'not-empty'
                        ]
                    ],
                    [
                        'fields' => ''
                    ],
                ],
                'message' => 'Record[1] "fields" should be Array'
            ],
        ];
    }

    /**
     * @dataProvider badCreateDataProvider
     * @param string $tableName
     * @param array $records
     * @param string $message
     */
    public function testThatCreateRecordsThrowsExpectedExceptionWithBadData(
        string $tableName,
        array $records,
        string $message
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        TableRequest::createRecords($tableName, $records);
    }

    public function testThatCreateRecordsReturnsCorrectlyFormattedRequest(): void
    {
        $tableName = sha1(random_bytes(10));
        $testRecords = [
            [
                'fields' => [
                    'Name' => 'bob'
                ]
            ]
        ];
        $createRequest = TableRequest::createRecords($tableName, $testRecords);

        $this->assertEquals(
            $tableName,
            $createRequest->getUri()->getPath()
        );

        $this->assertEquals(
            json_encode(['records' => $testRecords]),
            $createRequest->getBody()->getContents()
        );
    }

    public function testThatCreateRecordsWithEmptyFieldsReturnsObjectEncoded(): void
    {
        $testRecords = [
            [
                'fields' => []
            ]
        ];
        $createRequest = TableRequest::createRecords('tableName', $testRecords);
        $this->assertEquals(
            '{"records":[{"fields":{}}]}',
            $createRequest->getBody()->getContents()
        );
    }


    public function badReadRecordsDataProvider(): array
    {
        return [
            'table name empty' => [
                'tableName' => '',
                'id' => sha1(random_bytes(10)),
                'message' => 'Table name must not be empty'
            ],
            'id empty' => [
                'tableName' => sha1(random_bytes(10)),
                'id' => '',
                'message' => 'Record Id must not be empty'
            ]
        ];
    }

    /**
     * @dataProvider badReadRecordsDataProvider
     * @param string $tableName
     * @param string $id
     * @param string $message
     */
    public function testThatReadRecordsThrowsExpectedExceptionWithBadData(
        string $tableName,
        string $id,
        string $message
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        TableRequest::readRecords($tableName, $id);
    }

    public function testThatReadRecordsReturnsCorrectlyFormattedRequest(): void
    {
        $tableName = sha1(random_bytes(10));
        $id = sha1(random_bytes(10));

        $readRecordsRequest = TableRequest::readRecords($tableName, $id);

        $this->assertSame(
            sprintf('%s/%s', $tableName, $id),
            $readRecordsRequest->getUri()->getPath()
        );

        $this->assertEmpty($readRecordsRequest->getBody()->getContents());
    }
}
