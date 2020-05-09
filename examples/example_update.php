<?php

// @todo refactor to TableRequest->updateRecords()

// example usage file
require_once('../vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$baseId = 'app8x7Rjk38VF0z8V';
$tableName = 'Content production';
$viewName = 'Content pipeline';

$airtableClient = new AirtableClient(getenv('API_KEY'), $baseId);

$table = $airtableClient->getTable($tableName, $viewName);

$jsonData = '{
  "records": [
    {
      "id": "recZkovNIUzjkU4eR",
      "fields": {
        "Headline": "Poolside views - Adam",
        "Section": "Our picks",
        "Author": {
          "id": "usru7j5m2lcNhriKv",
          "email": "katherineduh+collab7@demo.htable.com",
          "name": "Beachcasts Cameron Toth"
        },
        "Publish date": "2020-08-07",
        "Status": "Planned",
        "Header image": [
          {
            "id": "attXyELDVIz2WeHUI"
          }
        ],
        "Draft due": "2020-07-27",
        "Freelancer timesheets": [
          "recXRf9mydNR4KfRw"
        ]
      }
    }
  ]
 }';

$data = json_decode($jsonData, true);

$content = $table->update($data, 'patch');

echo $content->getBody()->getContents();
