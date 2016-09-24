<?php
namespace CASS\Domain\Bundles\Profile;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use CASS\Domain\Bundles\Profile\Backdrop\Preset\ProfileBackdropPresetFactory;
use CASS\Domain\Bundles\Profile\Backdrop\Upload\ProfileBackdropUploadStrategyFactory;
use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Bundles\Profile\Entity\Profile;
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
        'config.paths.profile.backdrop.presets.json' => factory(function(Container $container) {
            return json_encode(
                file_get_contents(sprintf('%s/presets/profile/presets.json', $container->get('config.storage.dir')))
            );
        }),
        'config.paths.profile.avatar.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/profile/by-sid/avatar/', $container->get('config.storage.dir'));
        }),
        'config.paths.profile.avatar.www' => factory(function(Container $container) {
            return sprintf('%s/entity/profile/by-sid/avatar/', $container->get('config.storage.www'));
        }),
        'config.paths.profile.backdrop.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/profile/by-sid/backdrop/', $container->get('config.storage.dir'));
        }),
        'config.paths.profile.backdrop.www' => factory(function(Container $container) {
            return sprintf('%s/entity/profile/by-sid/backdrop/', $container->get('config.storage.www'));
        }),
        ProfileRepository::class => factory(new DoctrineRepositoryFactory(Profile::class)),
        ProfileExpertInEQRepository::class => factory(new DoctrineRepositoryFactory(ProfileExpertInEQ::class)),
        ProfileInterestingInEQRepository::class => factory(new DoctrineRepositoryFactory(ProfileInterestingInEQ::class)),
        ProfileBackdropPresetFactory::class => object()
            ->constructorParameter('json', factory(function(Container $container) {
                return $container->get('config.paths.profile.backdrop.presets.json');
            })),
        ProfileBackdropUploadStrategyFactory::class => object()
            ->constructorParameter('wwwPath', factory(function(Container $container) {
                return $container->get('config.paths.profile.backdrop.www');
            }))
            ->constructorParameter('storagePath', factory(function(Container $container) {
                return $container->get('config.paths.profile.backdrop.dir');
            }))
            ->constructorParameter('fileSystem', factory(function(Container $container) {
                $env = $container->get('config.env');
                $dir = $container->get('config.paths.profile.backdrop.dir');

                if($env === 'test') {
                    return new Filesystem(new MemoryAdapter($dir));
                }else{
                    return new Filesystem(new Local($dir));
                }
            }))
    ],
    'env' => [
        'development' => $configDefault,
        'production' => $configDefault,
        'stage' => $configDefault,
        'test' => $configTest,
    ]
];