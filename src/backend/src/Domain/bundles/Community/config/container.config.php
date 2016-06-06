<?php
namespace Domain\Community;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Application\Service\CommandService;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Community\Entity\Community;
use Domain\Community\Feature\FeaturesFactory;
use Domain\Community\Feature\Features\BoardsFeature;
use Domain\Community\Feature\Features\ChatFeature;
use Domain\Community\Feature\Features\CollectionsFeature;
use Domain\Community\Middleware\Command\CreateCommand;
use Domain\Community\Middleware\Command\EditCommand;
use Domain\Community\Middleware\Command\Feature\ActivateFeatureCommand;
use Domain\Community\Middleware\Command\Feature\DeactivateFeatureCommand;
use Domain\Community\Middleware\Command\Feature\IsFeatureActivatedCommand;
use Domain\Community\Middleware\Command\GetByIdCommand;
use Domain\Community\Middleware\Command\getBySIDCommand;
use Domain\Community\Middleware\Command\ImageUploadCommand;
use Domain\Community\Middleware\CommunityFeaturesMiddleware;
use Domain\Community\Middleware\CommunityMiddleware;
use Domain\Community\Repository\CommunityRepository;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Community\Scripts\FeaturesListFrontlineScript;
use Domain\Community\Service\CommunityFeaturesService;
use Domain\Community\Service\CommunityService;
use Domain\Profile\Repository\ProfileRepository;
use Domain\Theme\Repository\ThemeRepository;

return [
    'php-di' => [
        CommunityRepository::class => factory(new DoctrineRepositoryFactory(Community::class)),
        CommunityService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(CommunityRepository::class),
            get(ThemeRepository::class),
            get(CollectionRepository::class),
            get(ProfileRepository::class),
            factory(function(Container $container) {
                return sprintf('%s/community/community-image', $container->get('config.storage'));
            }),
            '/public/assets/storage/community/community-image'
        ),
        CommunityMiddleware::class => object()->constructor(
            get(CommandService::class)
        ),
        CommunityFeaturesService::class => object()->constructor(
            get(CommunityRepository::class),
            get(FeaturesFactory::class)
        ),
        CreateCommand::class => object()->constructor(
            get(CurrentAccountService::class),
            get(CommunityService::class)
        ),
        EditCommand::class => object()->constructor(
            get(CurrentAccountService::class),
            get(CommunityService::class)
        ),
        ImageUploadCommand::class => object()->constructor(
            get(CurrentAccountService::class),
            get(CommunityService::class)
        ),
        GetByIdCommand::class => object()->constructor(
            get(CurrentAccountService::class),
            get(CommunityService::class)
        ),
        getBySIDCommand::class => object()->constructor(
            get(CurrentAccountService::class),
            get(CommunityService::class)
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
            get(CommandService::class)
        ),
        FeaturesListFrontlineScript::class => object()->constructor(
            get(FeaturesFactory::class)
        ),
        FeaturesFactory::class => object()->constructor(
            get(Container::class)
        ),
        CollectionsFeature::class => object()->constructor(),
        BoardsFeature::class => object()->constructor(),
        ChatFeature::class => object()->constructor(),
    ]
];