<?php
use Auth\Service\CurrentAccountService;
use Common\Factory\DoctrineRepositoryFactory;
use ProfileIM\Repository\ProfileMessageRepository;
use ProfileIM\Service\ProfileIMService;
use Profile\Middleware\ProfileMiddleware;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        ProfileMessageRepository::class => factory(new DoctrineRepositoryFactory(\ProfileIM\Entity\ProfileMessage::class)),
        ProfileIMService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(ProfileMessageRepository::class)
        ),
        ProfileMiddleware::class => object()->constructor(
            get(CurrentAccountService::class),
            get(ProfileIMService::class)
        )
    ]
];