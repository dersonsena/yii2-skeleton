<?php

$dbName = YII_ENV_TEST ? $_ENV['DB_DATABASE_TEST'] : $_ENV['DB_DATABASE'];
$port = $_ENV['DB_PORT'] ?? 3306;

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host={$_ENV['DB_HOST']};port={$port};dbname={$dbName}",
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => YII_ENV_PROD,
    'schemaCacheDuration' => $_ENV['DB_SCHEMA_CACHE_DURATION'],
    'schemaCache' => 'db-schema-cache',
];
