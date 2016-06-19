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

return [
    'php-di' => [
        'config.paths.community.assets.dir' => factory(function(Container $container) {
            return sprintf('%s/community/by-sid/avatar/', $container->get('config.paths.assets.dir'));
        }),
        CommunityRepository::class => factory(new DoctrineRepositoryFactory(Community::class)),
        CommunityService::class => object()
            ->constructorParameter('imageFileSystem', factory(function(Container $container) {
                return new Filesystem(new Local($container->get('config.paths.community.assets.dir')));
            })),
    ],
];