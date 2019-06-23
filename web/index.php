<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * Load application environment from .env file
 */
$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
