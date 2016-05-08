<?php
use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Auth\Service\CurrentAccountService;
use Application\Common\Factory\DoctrineRepositoryFactory;
use Application\ProfileIM\Middleware\ProfileIMMiddleware;
use Application\ProfileIM\Repository\ProfileMessageRepository;
use Application\ProfileIM\Service\ProfileIMService;
use Application\Profile\Service\ProfileService;

return [
    'php-di' => [
        ProfileMessageRepository::class => factory(new DoctrineRepositoryFactory(\Application\ProfileIM\Entity\ProfileMessage::class)),
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