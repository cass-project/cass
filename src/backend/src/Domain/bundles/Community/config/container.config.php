<?php
namespace Domain\Community;

use DI\Container;
use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Community\Entity\Community;
use Domain\Community\Middleware\CommunityMiddleware;
use Domain\Community\Repository\CommunityRepository;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Community\Service\CommunityService;
use Domain\Theme\Repository\ThemeRepository;

return [
    'php-di' => [
        CommunityRepository::class => factory(new DoctrineRepositoryFactory(Community::class)),
        CommunityService::class => object()->constructor(
            get(CommunityRepository::class),
            get(ThemeRepository::class),
            factory(function(Container $container) {
                return sprintf('%s/community/community-image', $container->get('config.storage'));
            }),
            '/public/assets/storage/community/community-image'
        ),
        CommunityMiddleware::class => object()->constructor(
            get(CommunityService::class)
        )
    ]
];