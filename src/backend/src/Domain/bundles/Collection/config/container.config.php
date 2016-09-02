<?php
namespace CASS\Domain\Bundles\Collection;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Collection\Entity\CollectionThemeEQEntity;
use CASS\Domain\Bundles\Collection\Repository\CollectionRepository;
use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Bundles\Collection\Repository\CollectionThemeEQRepository;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

return [
    'php-di' => [
        'config.paths.collection.avatar.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/collection/by-sid/avatar/', $container->get('config.storage.dir'));
        }),
        'config.paths.collection.avatar.www' => factory(function(Container $container) {
            return sprintf('%s/entity/collection/by-sid/avatar/', $container->get('config.storage.www'));
        }),
        CollectionRepository::class => factory(new DoctrineRepositoryFactory(Collection::class)),
        CollectionThemeEQRepository::class => factory(new DoctrineRepositoryFactory(CollectionThemeEQEntity::class)),
        CollectionService::class => object()
            ->constructorParameter('wwwImagesDir', factory(function(Container $container) {
                return $container->get('config.paths.collection.avatar.www');
            }))
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