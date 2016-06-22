<?php
namespace Domain\Profile;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;
use Domain\Profile\Entity\ProfileExpertInEQ;
use Domain\Profile\Entity\ProfileInterestingInEQ;
use Domain\Profile\Repository\ProfileExpertInEQRepository;
use Domain\Profile\Repository\ProfileInterestingInEQRepository;
use Domain\Profile\Repository\ProfileRepository;
use Domain\Profile\Service\ProfileService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

return [
    'php-di' => [
        'config.paths.profile.avatar.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/profile/by-sid/avatar/', $container->get('config.paths.assets.dir'));
        }),
        ProfileRepository::class => factory(new DoctrineRepositoryFactory(Profile::class)),
        ProfileExpertInEQRepository::class => factory(new DoctrineRepositoryFactory(ProfileExpertInEQ::class)),
        ProfileInterestingInEQRepository::class => factory(new DoctrineRepositoryFactory(ProfileInterestingInEQ::class)),
    ],
    'env' => [
        'development' => [
            'php-di' => [
                ProfileService::class => object()
                    ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                        return new Filesystem(new Local($container->get('config.paths.profile.avatar.dir')));
                    })),
            ]
        ],
        'production' => [
            'php-di' => [
                ProfileService::class => object()
                    ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                        return new Filesystem(new Local($container->get('config.paths.profile.avatar.dir')));
                    })),
            ]
        ],
        'test' => [
            'php-di' => [
                ProfileService::class => object()
                    ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                        return new Filesystem(new MemoryAdapter($container->get('config.paths.profile.avatar.dir')));
                    })),
            ]
        ]
    ]
];