---
permalink: /update.html
---

## Update() method usage

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

$content = $table->update($data['records'], 'patch');

echo $content->getBody()->getContents();
```
