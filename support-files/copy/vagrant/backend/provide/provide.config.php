<?php
namespace Application;

return [
    'php-di' => [
        'config.env' => 'development',
        'config.doctrine2' => [
            'connection_options' => [
                'host'     => '127.0.0.1',
                'dbname'   => 'cass_development',
                'user'     => 'root',
                'password' => '1234',
            ]
        ],
        'config.sphinx' => [
            'connection_options'=> [
                'server' => 'unix:///tmp/sphinx.socket',
            ]
        ],
        'config.amqp' => [
            'host' => 'localhost',
            'port' => 5672,
            'user' => 'guest',
            'pass' => 'guest'
        ],
        'config.console' => [
            'title' => 'CASS Console',
            'version' => 'dev'
        ]
    ]
];