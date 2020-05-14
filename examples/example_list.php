<?php

// example usage file
require_once('../vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$baseId = 'app8x7Rjk38VF0z8V';
$tableName = 'Content production';
$viewName = 'Content pipeline';

$airtableClient = new AirtableClient(Config::fromEnvironment(), $baseId);

$table = $airtableClient->getTable($tableName, $viewName);

$params = [
    'maxRecords' => 3,
    'view' => $viewName
];

$content = $table->list($params);

echo $content->getBody()->getContents();
