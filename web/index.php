<?php
require __DIR__ . '/../vendor/autoload.php';

defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

$application = new yii\web\Application($config);
require __DIR__ . '/../config/aliases.php';

$application->run();
