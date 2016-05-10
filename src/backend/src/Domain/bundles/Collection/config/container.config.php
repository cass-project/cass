<?php
namespace Domain\Collection;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Middleware\CollectionMiddleware;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Collection\Service\CollectionService;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Community\Repository\CommunityRepository;
use Domain\Profile\Repository\ProfileRepository;
use Domain\Theme\Repository\ThemeRepository;

return [
    'php-di' => [
        CollectionRepository::class => factory(new DoctrineRepositoryFactory(Collection::class)),
        CollectionService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(CollectionRepository::class),
            get(CommunityRepository::class),
            get(ProfileRepository::class)
        ),
        CollectionMiddleware::class => object()->constructor(
            get(CollectionService::class),
            get(CurrentAccountService::class)
        ),
    ]
];