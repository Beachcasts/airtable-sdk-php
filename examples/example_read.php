<?php

// example usage file
require_once('../vendor/autoload.php');

use Beachcasts\Airtable\AirtableClient;

Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$baseId = 'app8x7Rjk38VF0z8V';
$tableName = 'Content production';
$viewName = 'Content pipeline';

$airtableClient = new AirtableClient(getenv('API_KEY'), $baseId);

$table = $airtableClient->getTable($tableName, $viewName);

$id = 'recZkovNIUzjkU4eR';
$content = $table->read($id);

echo $content->getBody()->getContents();
