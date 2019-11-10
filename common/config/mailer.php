<?php
return [
    'class' => 'yii\swiftmailer\Mailer',
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => env('SMTP_HOST'),
            'username' => env('SMTP_USERNAME'), 
            'password' => env('SMTP_PASSWORD'), 
            'port' => env('SMTP_PORT'),
            'encryption' => 'tls',
        ],
        'htmlLayout' => '@vendor/artsoft/yii2-art-auth/views/mail/layouts/html',
        'textLayout' => '@vendor/artsoft/yii2-art-auth/views/mail/layouts/text',
];