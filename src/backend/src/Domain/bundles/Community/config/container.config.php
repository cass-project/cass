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

return [
    'php-di' => [
        CommunityRepository::class => factory(new DoctrineRepositoryFactory(Community::class)),
        CommunityService::class => object()
            ->constructorParameter('storageDir', factory(function(Container $container) {
                    return sprintf('%s/community/community-image', $container->get('config.storage'));
            }))
            ->constructorParameter('publicPath', '/public/assets/storage/community/community-image'),
    ]
];