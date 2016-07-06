<?php
namespace Domain\Collection;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Entity\CollectionThemeEQEntity;
use Domain\Collection\Repository\CollectionRepository;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Collection\Repository\CollectionThemeEQRepository;
use Domain\Collection\Service\CollectionService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

return [
    'php-di' => [
        CollectionRepository::class => factory(new DoctrineRepositoryFactory(Collection::class)),
        CollectionThemeEQRepository::class => factory(new DoctrineRepositoryFactory(CollectionThemeEQEntity::class)),
        'config.paths.collection.avatar.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/collection/by-sid/avatar/', $container->get('config.paths.assets.dir'));
        }),
        CollectionService::class => object()
            ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                $env = $container->get('config.env');

                if($env === 'test') {
                    return new Filesystem(new MemoryAdapter($container->get('config.paths.collection.avatar.dir')));
                }else{
                    return new Filesystem(new Local($container->get('config.paths.collection.avatar.dir')));
                }
            }))
    ],
];