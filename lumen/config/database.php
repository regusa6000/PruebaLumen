<?php
return [

    'default' => env('DB_DEFAULT', 'mysql'),
    'migrations' => 'migrations',
    'connections' => [

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', 'my_app'),
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'human_resources_testing' => [
            'driver'    => 'mysql',
            'host'      => env('TEST_DB_HOST', 'localhost'),
            'database'  => env('TEST_DB_DATABASE', 'my_app_testing'),
            'username'  => env('TEST_DB_USERNAME', 'root'),
            'password'  => env('TEST_DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
    ],
];
    ?>
