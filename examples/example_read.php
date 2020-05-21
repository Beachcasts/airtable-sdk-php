<?php

// example usage file
require_once('../vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$baseId = 'app8x7Rjk38VF0z8V';
$tableName = 'Content production';

$airtableClient = new AirtableClient(Config::fromEnvironment(), $baseId);

$table = $airtableClient->getTable($tableName);

$id = 'recZkovNIUzjkU4eR';
$content = $table->read($id);

echo $content->getBody()->getContents();
