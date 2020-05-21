---
permalink: /connection.html
---

## Connection/Client() usage example

``` php
require_once('vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;

$airtableClient = new AirtableClient(Config::fromEnvironment(), <your_baseid>);
$table = $airtableClient->getTable(<your_table_name>);
```

NOTE: Update `<your_baseid>` and `<your_table_name>` as needed.
