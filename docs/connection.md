---
permalink: /connection.html
---

## Connection/Client() usage example

There are two supported methods for credential handling in this SDK. The `ENV method`, and the `dependency injection method`. Both are shown below.

### The ENV Method (recommended)

Copy the file `.env.default` to `.env`, and update as needed.

In your code include the [Vlucas/phpdotenv](https://packagist.org/packages/vlucas/phpdotenv) package using `composer`, or another installation method provided by the package. (Composer recommended)

In your code you would use this package to load the contents of the `.env` file like so:

```php
require_once('vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;

Dotenv\Dotenv::createImmutable(__DIR__)->load();

$airtableClient = new AirtableClient(Config::fromEnvironment(), <your_baseid>);

$table = $airtableClient->getTable(<your_table_name>);
```

Then, you can continue using the `Table` object as desired for CRUD+L actions.

### The Dependency Injection Method

Using this method is done by calling a different method in the `Config`, as it is being instantiated. Example:

```php
require_once('vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;

$airtableClient = new AirtableClient(
    Config::fromValues(
        string $baseUrl,
        string $version,
        string $apiKey
    ),
    <your_baseid>
);

$table = $airtableClient->getTable(<your_table_name>);
```

Then, you can continue using the `Table` object as desired for CRUD+L actions.

## Next Steps

After handling connection with the `AirtableClient`, you are ready to use the SDK to handle any CRUD+L actions. Please refer to the sidebar for navigation, as desired.
