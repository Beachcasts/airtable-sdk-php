<?php

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
      "fields": {
        "Headline": "Poolside views",
        "Section": "Our picks",
        "Author": {
          "id": "usru7j5m2lcNhriKv",
          "email": "katherineduh+collab7@demo.htable.com",
          "name": "Cameron Toth"
        },
        "Publish date": "2020-08-07",
        "Status": "Planned",
        "Header image": [
          {
            "url": "https://dl.airtable.com/pQXlwEtaSu8uo9dYZKvQ_pexels-photo-261102.jpeg%3Fh%3D350%26auto%3Dcompress%26cs%3Dtinysrgb"
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

$content = $table->create($data['records']);

echo $content->getBody()->getContents();
