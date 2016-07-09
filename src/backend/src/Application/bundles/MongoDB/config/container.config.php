<?php
namespace Application\MongoDB;

use function DI\object;
use function DI\factory;
use function DI\get;

use MongoDB;
use DI\Container;

return [
    'php-di' => [
        MongoDB::class => factory(function(Container $container) {
            $env = $container->get('config.env');
            $config = $container->get('config.mongodb');
            
            $mongoClient = new \MongoClient(
                $config['server'] ?? 'mongodb://127.0.0.1:27017',
                $config['options'] ?? ['connect' => true],
                $config['driver_options'] ?? []
            );
            
            return $mongoClient->selectDB(sprintf('%s_%s', $config['db_prefix'] ?? 'cass', $env));
        })
    ]
];