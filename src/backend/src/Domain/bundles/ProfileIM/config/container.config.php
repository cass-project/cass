<?php
use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Auth\Service\CurrentAccountService;
use Application\Common\Factory\DoctrineRepositoryFactory;
use Domain\ProfileIM\Middleware\ProfileIMMiddleware;
use Domain\ProfileIM\Repository\ProfileMessageRepository;
use Domain\ProfileIM\Service\ProfileIMService;
use Domain\Profile\Service\ProfileService;

return [
    'php-di' => [
        ProfileMessageRepository::class => factory(new DoctrineRepositoryFactory(\Domain\ProfileIM\Entity\ProfileMessage::class)),
        ProfileIMService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(ProfileMessageRepository::class)
        ),
        ProfileIMMiddleware::class => object()->constructor(
            get(CurrentAccountService::class),
            get(ProfileIMService::class),
            get(ProfileService::class)
        )
    ]
];