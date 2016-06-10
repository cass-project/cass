<?php
namespace Domain\Collection;

use DI\Container;
use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Collection\Entity\Collection;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Collection\Service\CollectionService;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;

return [
    'php-di' => [
        CollectionRepository::class => factory(new DoctrineRepositoryFactory(Collection::class)),
        CollectionService::class => object()
          ->constructorParameter('storageDir', factory(function(Container $container) {
              return sprintf('%s/collection/community-image', $container->get('config.storage'));
          }))
          ->constructorParameter('publicPath','/public/assets/storage/collection/community-image')
    ]
];