<?php
namespace Domain\Community;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Application\Service\CommandService;
use Domain\Community\Entity\Community;
use Domain\Community\Middleware\Command\Feature\ActivateFeatureCommand;
use Domain\Community\Middleware\Command\Feature\DeactivateFeatureCommand;
use Domain\Community\Middleware\Command\Feature\IsFeatureActivatedCommand;
use Domain\Community\Middleware\CommunityFeaturesMiddleware;
use Domain\Community\Middleware\CommunityMiddleware;
use Domain\Community\Repository\CommunityRepository;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Community\Service\CommunityFeaturesService;
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
        ),
        CommunityFeaturesService::class => object()->constructor(
            get(CommunityRepository::class)
        ),
        ActivateFeatureCommand::class => object()->constructor(
            get(CommunityService::class),
            get(CommunityFeaturesService::class)
        ),
        DeactivateFeatureCommand::class => object()->constructor(
            get(CommunityService::class),
            get(CommunityFeaturesService::class)
        ),
        IsFeatureActivatedCommand::class => object()->constructor(
            get(CommunityService::class),
            get(CommunityFeaturesService::class)
        ),
        CommunityFeaturesMiddleware::class => object()->constructor(
            CommandService::class
        )
    ]
];