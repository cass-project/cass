<?php
namespace Post;

use Profile\Factory\Middleware\ProfileMiddlewareFactory;
use Profile\Factory\Repository\ProfileGreetingsRepositoryFactory;
use Profile\Factory\Repository\ProfileImageRepositoryFactory;
use Profile\Factory\Repository\ProfileRepositoryFactory;
use Profile\Middleware\ProfileMiddleware;
use Profile\Repository\ProfileGreetingsRepository;
use Profile\Repository\ProfileImageRepository;
use Profile\Repository\ProfileRepository;

return [
    'zend_service_manager' => [
        'factories' => [
            ProfileRepository::class => ProfileRepositoryFactory::class,
            ProfileImageRepository::class => ProfileImageRepositoryFactory::class,
            ProfileGreetingsRepository::class => ProfileGreetingsRepositoryFactory::class,
            ProfileMiddleware::class => ProfileMiddlewareFactory::class,
        ]
    ]
];