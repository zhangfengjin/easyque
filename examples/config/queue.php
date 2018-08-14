<?php
return [
    "default" => "redis",

    "connections" => [
        "redis" => [
            'connection' => 'default',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => null,
        ],
        "mysql" => [
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ]
    ],

    "dirver" => [
        "redis" => [
            'client' => 'predis',
            'default' => [
                'host' => '127.0.0.1',
                'password' => null,
                'port' => 6379,
                'database' => 0,
            ],
        ],
        "mysql" => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'forge',
            'username' => 'forge',
            'password' => '',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]
    ]

];