# airtable-sdk-php

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This Airtable SDK for PHP makes it easier to leverage the Airtable API leveraging popular PHP conventions.

NOTE: This project is under active development, and is NOT ready for use.

## Documentation

Go to: [https://beachcasts.github.io/airtable-sdk-php/](https://beachcasts.github.io/airtable-sdk-php/)

## Prerequisites

* Composer installed globally
* PHP v7.2+

## Install

Via Composer

``` bash
$ composer require beachcasts/airtable-sdk-php
```

## Quick Start

Base usage requires instantiation of the AirtableClient, as shown below:

``` php
require_once('vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;

// Add details to your environment - see documentation for recomendations

$airtableClient = new AirtableClient(Config::fromEnvironment(), <your_baseid>);
$table = $airtableClient->getTable(<your_table_name>);
```

##### NOTES:
1. Update `<your_baseid>` and `<your_table_name>` as needed.
1. the `Config::fromEnvironment`

For more details of how to use the AirtableClient, see the [/docs](https://beachcasts.github.io/airtable-sdk-php/), where examples highlight using `create()`, `read()`, `update()`, `delete()`, and `list()` methods on/with Airtable data.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

Airtable-SDK has 3 Test Suites: Full, Unit and Integration, we include a Dev requirement against PHPUnit.
Please make sure you run the composer install to get all dependencies.
```bash
$ composer install
```

#### Unit Tests

Running the unit tests is simply telling phpunit to run the "unit" testsuite

```bash
$ vendor/bin/phpunit --testsuite=unit
```

#### Integration Tests

Running the integration tests will require an actual account and details from Airtable.

1. Copy the file `tests\.env.default` to `tests\.env`
1. Log into your Airtable account
1. `Add a base` using the `Start from scratch` method.
Let the new base creation retain the default `Untitled Base` name.
1. Visit [Airtable API docs](https://airtable.com/api) and select your `Base`
1. Copy the Base ID from the Introduction section. Look for `The ID of this base is`
Add this to the `tests\.env` under the `TEST_BASE_ID` key
1. Go to [Your account](https://airtable.com/account) and copy your API Key.
Add this to the `tests\.env` under the `AIRTABLE_API_KEY` key
1. If you have changed the default Table name away from `Table 1` - update the `TEST_TABLE_NAME` in the `tests\.env`

Once the .env is configured, tests can be run with the following command:
```bash
$ vendor/bin/phpunit --testsuite=integration
```

#### Full Test Suite

To run the full Test Suite, you will need to follow the steps outlined for Integration testing. To Exceute, run the following command:
```bash
$ vendor/bin/phpunit --testsuite=full
```
or
```bash
$ vendor/bin/phpunit
```

## Quality Control

To maintain quality control, we maintain use of the following standards:
* [PSR-2](https://www.php-fig.org/psr/psr-2/) Coding Standard,
* [PSR-4](https://www.php-fig.org/psr/psr-4/) standard for Autoload locations (via composer)
* [PSR-7](https://www.php-fig.org/psr/psr-7/) standard for HTTP messages (via GuzzleHttp implementation)

We provide a `phpcs.xml.dist` within the codebase to validate the Coding standard using Code Sniffer (included as dev dependency in our composer.json manifest)

To run the codesniffer against the codebase, use the following command.

```bash
$ vendor/bin/phpcs --standard=phpcs.xml.dist src
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email beachcasts@gmail.com instead of using the issue tracker.

## Credits

- [Beachcasts][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/beachcasts/airtable-sdk-php.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/beachcasts/airtable-sdk-php/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/beachcasts/airtable-sdk-php.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/beachcasts/airtable-sdk-php.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/beachcasts/airtable-sdk-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/beachcasts/airtable-sdk-php
[link-travis]: https://travis-ci.com/beachcasts/airtable-sdk-php
[link-scrutinizer]: https://scrutinizer-ci.com/g/beachcasts/airtable-sdk-php/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/beachcasts/airtable-sdk-php
[link-downloads]: https://packagist.org/packages/beachcasts/airtable-sdk-php
[link-author]: https://github.com/beachcasts
[link-contributors]: ../../contributors
