<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => getenv('DB_DSN'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => getenv('DB_CHARSET'),

    // Schema cache options (for production environment)
    'enableSchemaCache' => getenv('DB_ENABLE_SCHEMA_CACHE'),
    'schemaCacheDuration' => getenv('DB_SCHEMA_CACHE_DURATION'),
    'schemaCache' => getenv('DB_SCHEMA_CACHE_NAME'),
];
