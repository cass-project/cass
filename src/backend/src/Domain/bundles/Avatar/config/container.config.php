<?php
namespace Domain\Colors;

use Application\Service\BundleService;
use DI\Container;
use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Avatar\Service\AvatarService;
use Domain\Avatar\Service\Strategy\FileAvatarStrategy;
use Domain\Avatar\Service\Strategy\MockAvatarStrategy;
use Domain\DomainBundle;

return [
    'php-di' => [
        FileAvatarStrategy::class => object()->constructorParameter('fontPath', factory(function(Container $container) {
            $domainBundle = $container->get(BundleService::class)->getBundleByName(DomainBundle::class); /** @var DomainBundle $domainBundle */

            return sprintf('%s/fonts/Roboto/Roboto-Medium.ttf', $domainBundle->getResourcesDir());
        }))
    ],
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