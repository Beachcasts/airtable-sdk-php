---
permalink: /read.html
---

## Read method usage

```php
require_once('../vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$baseId = <your_base_id>;
$tableName = <your_table_name>;

$airtableClient = new AirtableClient(Config::fromEnvironment(), $baseId);

$table = $airtableClient->getTable($tableName);

$id = <your_record_id>;
$content = $table->read($id);

echo $content->getBody()->getContents();

```
