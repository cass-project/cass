<?php
namespace CASS\Domain\Bundles\Profile;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;
use CASS\Domain\Bundles\Profile\Entity\ProfileExpertInEQ;
use CASS\Domain\Bundles\Profile\Entity\ProfileInterestingInEQ;
use CASS\Domain\Bundles\Profile\Repository\ProfileExpertInEQRepository;
use CASS\Domain\Bundles\Profile\Repository\ProfileInterestingInEQRepository;
use CASS\Domain\Bundles\Profile\Repository\ProfileRepository;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

$configDefault = [
    'php-di' => [
        ProfileService::class => object()
            ->constructorParameter('wwwImagesDir', factory(function(Container $container) {
                return $container->get('config.paths.profile.avatar.www');
            }))
            ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                return new Filesystem(new Local($container->get('config.paths.profile.avatar.dir')));
            })),
    ]
];
$configTest = [
    'php-di' => [
        ProfileService::class => object()
            ->constructorParameter('wwwImagesDir', factory(function(Container $container) {
                return $container->get('config.paths.profile.avatar.www');
            }))
            ->constructorParameter('imagesFlySystem', factory(function(Container $container) {
                return new Filesystem(new MemoryAdapter($container->get('config.paths.profile.avatar.dir')));
            })),
    ]
];

return [
    'php-di' => [
        'config.paths.profile.avatar.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/profile/by-sid/avatar/', $container->get('config.storage.dir'));
        }),
        'config.paths.profile.avatar.www' => factory(function(Container $container) {
            return sprintf('%s/entity/profile/by-sid/avatar/', $container->get('config.storage.www'));
        }),
        ProfileRepository::class => factory(new DoctrineRepositoryFactory(Profile::class)),
        ProfileExpertInEQRepository::class => factory(new DoctrineRepositoryFactory(ProfileExpertInEQ::class)),
        ProfileInterestingInEQRepository::class => factory(new DoctrineRepositoryFactory(ProfileInterestingInEQ::class)),
    ],
    'env' => [
        'development' => $configDefault,
        'production' => $configDefault,
        'stage' => $configDefault,
        'test' => $configTest,
    ]
];