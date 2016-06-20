<?php
namespace Domain\Collection;

use DI\Container;
use function DI\object;
use function DI\factory;
use function DI\get;

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
    ],
    'env' => [
        'production' => [
            'php-di' => [
                CollectionService::class => object()
                    ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                        $assetsDir = sprintf('%s/collection/by-sid/avatar', $container->get('config.paths.assets.dir'));

                        return new Filesystem(new Local($assetsDir));
                    }))
            ]
        ],
        'development' => [
            'php-di' => [
                CollectionService::class => object()
                    ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                        $assetsDir = sprintf('%s/collection/by-sid/avatar', $container->get('config.paths.assets.dir'));

                        return new Filesystem(new Local($assetsDir));
                    }))
            ]
        ],
        'test' => [
            'php-di' => [
                CollectionService::class => object()
                    ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                        $assetsDir = sprintf('%s/collection/by-sid/avatar', $container->get('config.paths.assets.dir'));

                        return new Filesystem(new MemoryAdapter($assetsDir));
                    }))
            ]
        ],
    ]
];