<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=62.109.7.245;dbname=saonline',
    'username' => 'saonline',
    'password' => '0000',
    'charset' => 'utf8',
	'enableSchemaCache'=>false,
    'schemaMap' => [
        'pgsql'=> [
            'class'=>'yii\db\pgsql\Schema',
            'defaultSchema' => 'public' //specify your schema here
        ]
    ],
];
