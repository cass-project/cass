<?php
namespace Domain\Community;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Domain\Community\Entity\Community;
use Domain\Community\Repository\CommunityRepository;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Community\Service\CommunityService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

$configDefault = [
    'php-di' => [
        CommunityService::class => object()
            ->constructorParameter('imageFileSystem', factory(function(Container $container) {
                return new Filesystem(new Local($container->get('config.paths.community.avatar.dir')));
            })),
    ]
];
$configMock = [
    'php-di' => [
        CommunityService::class => object()
            ->constructorParameter('imageFileSystem', factory(function(Container $container) {
                return new Filesystem(new MemoryAdapter($container->get('config.paths.community.avatar.dir')));
            })),
    ]
];

return [
    'php-di' => [
        'config.paths.community.avatar.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/community/by-sid/avatar/', $container->get('config.paths.assets.dir'));
        }),
        CommunityRepository::class => factory(new DoctrineRepositoryFactory(Community::class)),
    ],
    'env' => [
        'production' => $configDefault,
        'development' => $configDefault,
        'stage' => $configDefault,
        'test' => $configMock,
    ]
];