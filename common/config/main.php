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
            // 'useFileTransport' => false,    //这里一定要改成false，不然邮件不会发送
            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => 'smtp.gmail.com',
            //     'username' => 'cwx.xiaoc@gmail.com',
            //     'password' => 'fengfeng',        //如果是163邮箱，此处要填授权码
            //     'port' => '587',
            //     'encryption' => 'tls',
            // ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.qq.com',
                // 'username' => '236008243@qq.com',
                // 'password' => 'fengfeng',        //如果是163邮箱，此处要填授权码
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
    'language' => 'zh-CN',
];
