---
permalink: /list.html
---

## List() method usage

```php
require_once('../vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$baseId = <your_base_id>;
$tableName = <your_table_name>;
$viewName = <your_view_name>;

$airtableClient = new AirtableClient(Config::fromEnvironment(), $baseId);

$table = $airtableClient->getTable($tableName);

$params = [
    'maxRecords' => 3,
    'view' => $viewName
];

$content = $table->list($params);

echo $content->getBody()->getContents();
```
