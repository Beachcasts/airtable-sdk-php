<?php

// example usage file
require_once('../vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;
use Beachcasts\Airtable\Config;

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$baseId = 'app87iLOq33mUgCFA';
$tableName = 'Table 1';
$viewName = 'Grid view';

$airtableClient = new AirtableClient(Config::fromEnvironment(), $baseId);

$table = $airtableClient->getTable($tableName);

$params = [
    'maxRecords' => 3,
    'view' => $viewName
];

$content = $table->list($params);

echo $content->getBody()->getContents();
