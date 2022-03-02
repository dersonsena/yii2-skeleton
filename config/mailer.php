<?php

use yii\swiftmailer\Mailer;

return [
    'class' => Mailer::class,
    'viewPath' => '@app/mail',
    'enableSwiftMailerLogging' => !YII_ENV_PROD,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => $_ENV['SMTP_HOST'],
        'port' => $_ENV['SMTP_PORT'],
        'username' => $_ENV['SMTP_USERNAME'],
        'password' => $_ENV['SMTP_PASSWORD'],
        'encryption' => $_ENV['SMTP_ENCRYPTION']
    ]
];
