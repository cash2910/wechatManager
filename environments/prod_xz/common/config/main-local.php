<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=10.121.1.200;dbname=dream_core_xuezhan',
            'username' => 'xuezhan_plat_user',
            'password' => '123456',
            'charset' => 'utf8mb4',
        ],
        'redis' => [
            'class' => 'common\components\redis\Connection',
            'hostname' => '10.121.1.222',
            'password' => '9z0a_wang',
	    'port' => 6379,
            'database' => 2,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
