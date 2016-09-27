<?php
namespace CASS\Domain\Bundles\Community;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Repository\CommunityRepository;
use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Bundles\Community\Backdrop\Preset\CommunityBackdropPresetFactory;
use CASS\Domain\Bundles\Community\Backdrop\Upload\CommunityBackdropUploadStrategyFactory;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;


return [
    'php-di' => [
        'config.paths.community.backdrop.presets.json' => factory(function(Container $container) {
            return json_decode(
                file_get_contents(sprintf('%s/presets/community/presets.json', $container->get('config.storage.dir'))), true
            );
        }),
        'config.paths.community.avatar.www' => factory(function(Container $container) {
            return sprintf('%s/entity/community/by-sid/avatar/', $container->get('config.storage.www'));
        }),
        'config.paths.community.avatar.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/community/by-sid/avatar/', $container->get('config.storage.dir'));
        }),
        'config.paths.community.backdrop.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/community/by-sid/backdrop', $container->get('config.storage.dir'));
        }),
        'config.paths.community.backdrop.www' => factory(function(Container $container) {
            return sprintf('%s/entity/community/by-sid/backdrop', $container->get('config.storage.www'));
        }),
        CommunityRepository::class => factory(new DoctrineRepositoryFactory(Community::class)),
        CommunityService::class => object()
            ->constructorParameter('imageFileSystem', factory(function(Container $container) {
                $env = $container->get('config.env');

                if($env === 'test') {
                    return new Filesystem(new MemoryAdapter($container->get('config.paths.community.avatar.dir')));
                }else{
                    return new Filesystem(new Local($container->get('config.paths.community.avatar.dir')));
                }
            }))
            ->constructorParameter('wwwImageDir', factory(function(Container $container) {
                return $container->get('config.paths.community.avatar.www');
            }))
        ,
        CommunityBackdropPresetFactory::class => object()
            ->constructorParameter('json', factory(function(Container $container) {
                return $container->get('config.paths.community.backdrop.presets.json');
            })),
        CommunityBackdropUploadStrategyFactory::class => object()
            ->constructorParameter('wwwPath', factory(function(Container $container) {
                return $container->get('config.paths.community.backdrop.www');
            }))
            ->constructorParameter('storagePath', factory(function(Container $container) {
                return $container->get('config.paths.community.backdrop.dir');
            }))
            ->constructorParameter('fileSystem', factory(function(Container $container) {
                $env = $container->get('config.env');
                $dir = $container->get('config.paths.community.backdrop.dir');

                if($env === 'test') {
                    return new Filesystem(new MemoryAdapter($dir));
                }else{
                    return new Filesystem(new Local($dir));
                }
            }))
    ],
];