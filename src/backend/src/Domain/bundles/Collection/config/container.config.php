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

return [
    'php-di' => [
        CollectionRepository::class => factory(new DoctrineRepositoryFactory(Collection::class)),
        CollectionService::class => object()
            ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                $assetsDir = sprintf('%s/collection', $container->get('config.paths.assets.dir'));

                return new Filesystem(new Local($assetsDir));
            }))
        ,
    ]
];