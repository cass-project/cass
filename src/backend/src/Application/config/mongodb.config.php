<?php
namespace CASS\Application\MongoDB;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        'config.mongodb' => [
            'db_prefix' => 'cass',
            'server' => 'mongodb://127.0.0.1:27017',
            'options' => [
                'connect' => true
            ],
            'driver_options' => []
        ]
    ]
];