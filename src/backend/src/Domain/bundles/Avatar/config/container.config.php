<?php
namespace Domain\Colors;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Avatar\Service\AvatarService;
use Domain\Avatar\Service\Strategy\FileAvatarStrategy;
use Domain\Avatar\Service\Strategy\MockAvatarStrategy;

return [
    'env' => [
        'development' => [
            'php-di' => [
                AvatarService::class => object()->constructorParameter('strategy', get(FileAvatarStrategy::class))
            ]
        ],
        'production' => [
            'php-di' => [
                AvatarService::class => object()->constructorParameter('strategy', get(FileAvatarStrategy::class))
            ]
        ],
        'test' => [
            'php-di' => [
                AvatarService::class => object()->constructorParameter('strategy', get(MockAvatarStrategy::class))
            ]
        ]
    ]
];