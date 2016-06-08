<?php
namespace Domain\Collection;

use DI\Container;
use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Middleware\CollectionMiddleware;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Collection\Service\CollectionService;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Collection\Service\CollectionValidatorsService;

return [
    'php-di' => [
        CollectionRepository::class => factory(new DoctrineRepositoryFactory(Collection::class)),
        CollectionService::class => object()
          ->constructorParameter('storageDir', factory(function(Container $container) {
              return sprintf('%s/collection/community-image', $container->get('config.storage'));
          }))
          ->constructorParameter('publicPath','/public/assets/storage/collection/community-image')
          ,
        CollectionMiddleware::class => object()->constructor(
            get(CollectionService::class),
            get(CurrentAccountService::class)
        ),
        CollectionValidatorsService::class => object()->constructor(
            get(CurrentAccountService::class)
        )
    ]
];