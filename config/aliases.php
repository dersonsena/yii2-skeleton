<?php

// Yii::setAlias('app', dirname(__DIR__) . DS . 'src');
Yii::setAlias('App', dirname(__DIR__) . DS . 'src');
Yii::setAlias('webroot', dirname(__DIR__) . DS . 'web');
Yii::setAlias('root', dirname(__DIR__));
Yii::setAlias('storage', dirname(__DIR__) . DS . 'storage');

if (php_sapi_name() !== 'cli') {
    Yii::setAlias('web', $_ENV['APP_BASE_URL']);
}
