<?php

use Illuminate\Support\Str;

return [
    'migrations' => 'migrations',
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => '',
            'options' => [
                PDO::ATTR_PERSISTENT => true
            ],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'dump' => [
                'dump_binary_path' => 'C:/xampp/mysql/bin',
                'use_single_transaction' => true,
                'timeout' => 300,
                'add_extra_option' => '--host=127.0.0.1 --port=3306 --protocol=TCP --ssl-mode=DISABLED'
            ],
            // ... keep other configurations the same
        ],
        // ... other database connections
    ],
    // ... remaining config
];
