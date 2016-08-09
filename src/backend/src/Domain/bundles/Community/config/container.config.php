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


return [
    'php-di' => [
        'config.paths.community.avatar.www' => factory(function(Container $container) {
            return sprintf('%s/entity/community/by-sid/avatar/', $container->get('config.storage.www'));
        }),
        'config.paths.community.avatar.dir' => factory(function(Container $container) {
            return sprintf('%s/entity/community/by-sid/avatar/', $container->get('config.storage.dir'));
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
    ],
];