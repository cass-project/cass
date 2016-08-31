<?php
namespace CASS\Application\MongoDB;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use MongoDB\Database;
use MongoDB\Client;

return [
    'php-di' => [
        Database::class => factory(function(Container $container) {
            $env = $container->get('config.env');
            $config = $container->get('config.mongodb');

            $mongoClient = new Client(
                $config['server'] ?? 'mongodb://127.0.0.1:27017',
                $config['options'] ?? ['connect' => true],
                $config['driver_options'] ?? []
            );

            return $mongoClient->selectDatabase(sprintf('%s_%s', $config['db_prefix'] ?? 'cass', $env));
        })
    ]
];