# airtable-sdk-php

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This Airtable SDK for PHP makes it easier to leverage the Airtable API leveraging popular PHP conventions.

NOTE: This project is under active development, and is NOT ready for use.

## Prerequisites

* Composer installed globally
* PHP v7.2+

## Install

Via Composer

``` bash
$ composer require beachcasts/airtable-sdk-php
```

## Usage

Rename `.env.default` to `.env`, and update as needed.

Below is what a sample usage might look like, in the SDK current unfinished state.
``` php
require_once('vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;
use Beachcasts\Airtable\Table;

Dotenv\Dotenv::createImmutable(__DIR__)->load();
$baseId = getenv('BASE_ID');

$airtableClient = new AirtableClient(Config::fromEnvironment(), $baseId);

$table = $airtableClient->getTable('Content production');
$content = $table->list(['fields' = ['column_1_name']]);

echo $content->getBody()->getContents();
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing
Running the test suite requires the manual creation of a `Base` at Airtable. Log into your Airtable account and `Add a base` using the `Start from scratch` method. Let the new base creation retain the default `Untitled Base` name. You can customize as desired, but this will require you to also update the tests.

Next, you will need the `base_id` in order to run the tests, as well as the `api_key`. By going to the [Airtable API docs](https://airtable.com/api) you can now click into the new test base and view the `base_id`. Likewise, you can check the box in the upper right to display the api key.

Add the key and id to the `.env`, which can be created by copying the `.env.default` to `.env`, and updating as needed..

Following that, tests can be run with the following command:

``` bash
$ vendor/bin/phpunit
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
[link-travis]: https://travis-ci.org/beachcasts/airtable-sdk-php
[link-scrutinizer]: https://scrutinizer-ci.com/g/beachcasts/airtable-sdk-php/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/beachcasts/airtable-sdk-php
[link-downloads]: https://packagist.org/packages/beachcasts/airtable-sdk-php
[link-author]: https://github.com/beachcasts
[link-contributors]: ../../contributors
