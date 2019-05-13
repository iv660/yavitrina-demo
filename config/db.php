<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => $secure['db']['dsn'],
    'username' => $secure['db']['username'],
    'password' => $secure['db']['password'],
    'charset' => 'utf8',
    'tablePrefix' => $secure['db']['table_prefix'],

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
