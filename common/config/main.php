<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,    
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => 'task_auto@163.com',
                'password' => 'woleigequ1123456',
                'port' => '465',
                'encryption' => 'ssl',
            ],
            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => 'smtp.qq.com',
            //     'username' => '236008243@qq.com',
            //     'password' => 'fengfeng',        
            //     'port' => '587',
            //     'encryption' => 'tls',
            // ],
        ],
        'urlManager' => [
            'scriptUrl' => 'http://task.hexcoo.com',
            'baseUrl' => 'http://task.hexcoo.com'
        ]
    ],
    'language' => 'zh-CN',
];
