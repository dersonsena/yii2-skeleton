<?php

Yii::setAlias('app', dirname(__DIR__) . DS . 'src');
Yii::setAlias('App', dirname(__DIR__) . DS . 'src');
Yii::setAlias('webroot', dirname(__DIR__) . DS . 'web');

if (php_sapi_name() !== 'cli') {
    Yii::setAlias('web', (stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://' . $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] !== '80' ? ':' . $_SERVER['SERVER_PORT'] : '')));
}