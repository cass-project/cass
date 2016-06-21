<?php
namespace Domain\Collection;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Repository\CollectionRepository;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Collection\Service\CollectionService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

return [
    'php-di' => [
        CollectionRepository::class => factory(new DoctrineRepositoryFactory(Collection::class)),
        'config.paths.collection.avatar.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/collection/by-sid/avatar/', $container->get('config.paths.assets.dir'));
        }),
    ],
    'env' => [
        'production' => [
            'php-di' => [
                CollectionService::class => object()
                    ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                        return new Filesystem(new Local($container->get('config.paths.collection.avatar.dir')));
                    }))
            ]
        ],
        'development' => [
            'php-di' => [
                CollectionService::class => object()
                    ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                        return new Filesystem(new Local($container->get('config.paths.collection.avatar.dir')));
                    }))
            ]
        ],
        'test' => [
            'php-di' => [
                CollectionService::class => object()
                    ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                        return new Filesystem(new MemoryAdapter($container->get('config.paths.collection.avatar.dir')));
                    }))
            ]
        ],
    ]
];