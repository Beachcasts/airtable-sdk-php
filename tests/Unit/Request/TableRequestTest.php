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

    public function badUpdateRecordsDataProvider(): array
    {
        return [
            'table name empty' => [
                'tableName' => '',
                'records' => [],
                'type' => 'PATCH',
                'message' => 'Table name must not be empty'
            ],
            'records name empty' => [
                'tableName' => 'tableName',
                'records' => [],
                'type' => 'PATCH',
                'message' => 'Records must not be empty'
            ],
            'type not Patch or PUT' => [
                'tableName' => 'tableName',
                'records' => [[]],
                'type' => 'invalid',
                'message' => 'Update type should be either PATCH or PUT'
            ],
            'each record should have id' => [
                'tableName' => 'tableName',
                'records' => [
                    [

                    ]
                ],
                'type' => 'PATCH',
                'message' => 'Record[0] requires an "id" entry'
            ],
            'each record should have non empty id' => [
                'tableName' => 'tableName',
                'records' => [
                    [
                        'id' => ''
                    ]
                ],
                'type' => 'PATCH',
                'message' => 'Record[0] requires "id" to not be empty'
            ],
            'each record should have fields' => [
                'tableName' => 'tableName',
                'records' => [
                    [
                        'id' => random_int(11, 99),
                    ]
                ],
                'type' => 'PATCH',
                'message' => 'Record[0] should contain a "fields" entry'
            ],
            'each record fields should be an array' => [
                'tableName' => 'tableName',
                'records' => [
                    [
                        'id' => random_int(11, 99),
                        'fields' => '',
                    ]
                ],
                'type' => 'PATCH',
                'message' => 'Record[0] "fields" should be Array'
            ],
            'each record fields should not be empty' => [
                'tableName' => 'tableName',
                'records' => [
                    [
                        'id' => random_int(11, 99),
                        'fields' => [],
                    ]
                ],
                'type' => 'PATCH',
                'message' => 'Record[0] "fields" should not be empty'
            ],
            'each of record fields should string keyed' => [
                'tableName' => 'tableName',
                'records' => [
                    [
                        'id' => random_int(11, 99),
                        'fields' => [
                            0 => 'test'
                        ],
                    ]
                ],
                'type' => 'PATCH',
                'message' => 'Record[0] "fields" should be string-keyed'
            ],
        ];
    }

    /**
     * @dataProvider badUpdateRecordsDataProvider
     * @param string $tableName
     * @param array $records
     * @param string $type
     * @param string $message
     */
    public function testThatUpdateRecordsThrowsExpectedExceptionWithBadData(
        string $tableName,
        array $records,
        string $type,
        string $message
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        TableRequest::updateRecords($tableName, $records, $type);
    }

    public function testThatUpdateRecordsReturnsCorrectlyFormattedRequest(): void
    {
        $tableName = sha1(random_bytes(10));
        $records = [
            [
                'id' => random_int(11, 99),
                'fields' => [
                    'Name' => sha1(random_bytes(10))
                ]
            ]
        ];

        foreach (['PUT', 'PATCH'] as $type) {
            $updateRecordsRequest = TableRequest::updateRecords($tableName, $records, $type);

            $this->assertSame($type, $updateRecordsRequest->getMethod());
            $this->assertSame($tableName, $updateRecordsRequest->getUri()->getPath());
            $this->assertSame(
                json_encode(['records' => $records]),
                $updateRecordsRequest->getBody()->getContents()
            );
        }
    }

    public function badDeleteRecordsDataProvider(): array
    {
        $records['records'][]['id'] =  sha1(random_bytes(10));

        return [
            'table name empty' => [
                'tableName' => '',
                'records' => $records,
                'message' => 'Table name must not be empty'
            ],
            'records empty' => [
                'tableName' => sha1(random_bytes(10)),
                'records' => [],
                'message' => 'Records must not be empty'
            ]
        ];
    }

    /**
     * @dataProvider badDeleteRecordsDataProvider
     * @param string $tableName
     * @param array $records
     * @param string $message
     */
    public function testThatDeleteRecordsThrowsExpectedExceptionWithBadData(
        string $tableName,
        array $records,
        string $message
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        TableRequest::deleteRecords($tableName, $records);
    }

    public function testThatDeleteRecordsReturnsCorrectlyFormattedRequest(): void
    {
        $tableName = sha1(random_bytes(10));
        $records['records'][]['id'] = (string)random_int(11, 99);
        $test['records'][] = $records['records'][0]['id'];
        $queryEncoded = http_build_query($test);
        $deleteRecordsResponse = TableRequest::deleteRecords($tableName, $records);
        $this->assertSame($tableName, $deleteRecordsResponse->getUri()->getPath());
        $this->assertSame($queryEncoded, $deleteRecordsResponse->getUri()->getQuery());
    }

    public function badListRecordsDataProvider(): array
    {
        return [
            'table name empty' => [
                'tableName' => '',
                'params' => [],
                'message' => 'Table name must not be empty'
            ],
        ];
    }

    /**
     * @dataProvider badListRecordsDataProvider
     * @param string $tableName
     * @param array $params
     * @param string $message
     */
    public function testThatListRecordsThrowsExpectedExceptionWithBadData(
        string $tableName,
        array $params,
        string $message
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        TableRequest::listRecords($tableName, $params);
    }

    public function testThatListRecordsReturnsCorrectlyFormattedRequest(): void
    {
        $tableName = sha1(random_bytes(10));
        $params = ['test-random' => (string)random_int(11, 99)];
        $queryEncoded = http_build_query($params);
        $deleteRecordsResponse = TableRequest::listRecords($tableName, $params);
        $this->assertSame($tableName, $deleteRecordsResponse->getUri()->getPath());
        $this->assertSame($queryEncoded, $deleteRecordsResponse->getUri()->getQuery());
    }
}
