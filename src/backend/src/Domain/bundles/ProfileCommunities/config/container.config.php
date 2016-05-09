<?php
namespace Domain\ProfileCommunities;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Auth\Service\CurrentAccountService;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Domain\ProfileCommunities\Repository\ProfileCommunitiesRepository;
use Domain\ProfileCommunities\Service\ProfileCommunitiesService;

return [
    'php-di' => [
        ProfileCommunitiesRepository::class => factory(new DoctrineRepositoryFactory(ProfileCommunityEQ::class)),
        ProfileCommunitiesService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(ProfileCommunitiesRepository::class)
        ),
        ProfileCommunitiesService::class => object()->constructor(
            get(ProfileCommunitiesService::class)
        )
    ]
];