<?php
namespace Post;

use Profile\Factory\Middleware\ProfileMiddlewareFactory;
use Profile\Factory\Repository\ProfileRepositoryFactory;
use Profile\Middleware\ProfileMiddleware;
use Profile\Repository\ProfileRepository;

return [
    'zend_service_manager' => [
        'factories' => [
            ProfileRepository::class => ProfileRepositoryFactory::class,
            ProfileMiddleware::class => ProfileMiddlewareFactory::class,
        ]
    ]
];