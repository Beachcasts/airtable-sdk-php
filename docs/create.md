---
permalink: /create.html
---

## Create() method usage

```php
require_once('../vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$baseId = <your_base_id>;
$tableName = <your_table_name>;

$airtableClient = new AirtableClient(Config::fromEnvironment(), $baseId);

$table = $airtableClient->getTable($tableName);

// The following is dummy data, replace with your own
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
```
