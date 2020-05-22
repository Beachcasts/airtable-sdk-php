---
permalink: /start.html
---

## Getting Started

The first think you will need to do it create an [Airtable](https://airtable.com) account.

At the time of this writing, the Airtable API doesn't include functionality for creating a `Base`. Therefore, this SDK assumes you have already created a `Base` using the Airtable.com web-based gui.

Likewise, the Airtable API doesn't support the creation of a `Table` within the `Base`. Nor does it have functionality to create a `View` within a `Table`. So you will need to get your structure in place prior to using the API, or this SDK.

If Airtable adds this support to the API in the future, please let us know, so we can add it to the SDK.

## Installation

We recommend you install this SDK using [Composer](https://getcomposer.org). This allows dependencies to be easily loaded, and also enables PSR-4 style autoloading of the classes.

### Prerequisites

* [Composer](https://getcomposer.org) installed globally
* PHP v7.2+

### The Install

Using the terminal of your choice, issue the following command from within your application. (The command below assumes Linux OS.)

``` bash
$ composer require beachcasts/airtable-sdk-php
```

### Configuration

After installation, there are some configuration choices to make. We recommend you store credentials in the `environment` by loading the `.env` file using something like [Vlucas/phpdotenv](https://packagist.org/packages/vlucas/phpdotenv). However, you can just as easily inject the credentials into the AirtableClient on instantiation.

## Next Steps

Please use any of the links in the sidebar, or continue to [Connection](connection.html).
