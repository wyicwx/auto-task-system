<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=task',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            // 'enableParamLogging' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,    
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => '465',
                'encryption' => 'ssl',
            ]
        ],
        'urlManager' => [
            'scriptUrl' => '',
            'baseUrl' => ''
        ]
    ],
];
