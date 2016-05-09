<?php
namespace Application;

return [
    'env' => 'development',
    'php-di' => [
        'config.console' => [
            'title' => 'CASS Console',
            'version' => 'dev'
        ],
        'config.sphinx' => [
            'connection_options'=> [
                'server' => 'unix:///tmp/sphinx.socket',
            ]
        ],
        'config.doctrine2' => [
            'env.development' => [
                'connection_options' => [
                    'host'     => '127.0.0.1',
                    'dbname'   => 'cass_development',
                    'user'     => 'root',
                    'password' => '1234',
                ]
            ],
            'env.test' => [
                'connection_options' => [
                    'host'     => '127.0.0.1',
                    'dbname'   => 'cass_testing',
                    'user'     => 'root',
                    'password' => '1234',
                ]
            ]

        ],
        'config.amqp' => [
            'host' => 'localhost',
            'port' => 5672,
            'user' => 'guest',
            'pass' => 'guest'
        ],
    ],
];