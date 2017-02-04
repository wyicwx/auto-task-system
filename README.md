Online Auto Task System！
===============================


Setup
-------------------

Checkout code, and installing via [Composer](https://getcomposer.org/)

```
$ composer install 
```

Depending on your machine environment, modifying configure `environments/prod/common/config/main-local.php` or `environments/dev/common/config/main-local.php`. 

```
<?php
return [
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,    
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => '',
                'encryption' => '',
            ]
        ],
        'urlManager' => [
            'scriptUrl' => '',
            'baseUrl' => ''
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=task',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            // 'enableParamLogging' => true,
        ]
    ]
];
```

Run init to setup environment.

```
$ ./init
```

Import sql from `db.sql`

Crontab Configure 
-------------------

After installing, set crontab for timing execution.

```
0 * * * * /path/to/bin/php /path/to/task/yii task/schedule > /dev/null
*/5 * * * * /path/to/bin/php /path/to/task/yii task/run > /dev/null
0 9 * * * /path/to/bin/php /path/to/task/yii task/notice am > /dev/null
0 18 * * * /path/to/bin/php /path/to/task/yii task/notice pm > /dev/null
50 */2 * * * /path/to/bin/php /path/to/task/yii times/model > /dev/null
```

Frontend 
-------------------

Installing via [npm](https://www.npmjs.com/), your need [webpack](https://webpack.github.io/) cli also.

```
$ npm install webpack -g
```

install dependencies.

```
$ cd FE
$ npm install
```

run watch

```
$ webpack --watch
```