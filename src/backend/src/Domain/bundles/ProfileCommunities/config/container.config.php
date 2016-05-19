<?php
namespace Domain\ProfileCommunities;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Community\Repository\CommunityRepository;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Domain\ProfileCommunities\Middleware\ProfileCommunitiesMiddleware;
use Domain\ProfileCommunities\Repository\ProfileCommunitiesRepository;
use Domain\ProfileCommunities\Service\ProfileCommunitiesService;

return [
    'php-di' => [
        ProfileCommunitiesRepository::class => factory(new DoctrineRepositoryFactory(ProfileCommunityEQ::class)),
        ProfileCommunitiesService::class => object()->constructor(
            get(CommunityRepository::class),
            get(ProfileCommunitiesRepository::class),
            get(CurrentAccountService::class)
        ),
        ProfileCommunitiesMiddleware::class => object()->constructor(
            get(ProfileCommunitiesService::class)
        )
    ]
];