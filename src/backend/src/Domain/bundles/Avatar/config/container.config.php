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
    'env' => [
        'development' => [
            'php-di' => [
                AvatarService::class => object()->constructorParameter('strategy', get(FileAvatarStrategy::class))
                  ->constructorParameter('fontPath',factory(function(Container $container){
                      return sprintf('%s/fonts/Roboto/Roboto-Medium.ttf',
                                     $container->get(BundleService::class)->getBundleByName(DomainBundle::class )->getResourcesDir());
                  }))
            ]
        ],
        'production' => [
            'php-di' => [
                AvatarService::class => object()->constructorParameter('strategy', get(FileAvatarStrategy::class))
                  ->constructorParameter('fontPath',factory(function(Container $container){
                      return sprintf('%s/fonts/Roboto/Roboto-Medium.ttf',
                                     $container->get(BundleService::class)->getBundleByName(DomainBundle::class )->getResourcesDir());
                  }))
            ]
        ],
        'test' => [
            'php-di' => [
                AvatarService::class => object()->constructorParameter('strategy', get(MockAvatarStrategy::class))
                  ->constructorParameter('fontPath',factory(function(Container $container){
                      return sprintf('%s/fonts/Roboto/Roboto-Medium.ttf',
                                     $container->get(BundleService::class)->getBundleByName(DomainBundle::class )->getResourcesDir());
                  }))
            ]
        ]
    ]
];