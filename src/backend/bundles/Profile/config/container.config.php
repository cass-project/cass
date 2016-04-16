<?php
use Auth\Service\CurrentAccountService;
use Doctrine\ORM\EntityManager;
use Profile\Middleware\ProfileMiddleware;
use Profile\Repository\ProfileGreetingsRepository;
use Profile\Repository\ProfileImageRepository;
use Profile\Repository\ProfileRepository;
use Profile\Service\ProfileService;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        ProfileRepository::class => factory([EntityManager::class, 'getRepository']),
        ProfileImageRepository::class => factory([EntityManager::class, 'getRepository']),
        ProfileGreetingsRepository::class => factory([EntityManager::class, 'getRepository']),
        ProfileService::class => object()->constructor(
            get(ProfileRepository::class),
            sprintf('%s/profile/profile-image', get('constants.storage'))
        ),
        ProfileMiddleware::class => object()->constructor(
            get(ProfileService::class),
            get(CurrentAccountService::class)
        )
    ],
];