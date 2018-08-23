<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/6/7
 * Time: 21:31
 */
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=192.168.33.30;port=5432;dbname=jump',
    'username' => 'postgres',
    'password' => '123456',
    'charset' => 'utf8',
    'schemaMap' => [
        'pgsql'=> [
            'class'=>'yii\db\pgsql\Schema',
            'defaultSchema' => 'public' //specify your schema here
        ]
    ]
];