<?php
namespace Domain\ProfileCommunities;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Domain\ProfileCommunities\Repository\ProfileCommunitiesRepository;

return [
    'php-di' => [
        ProfileCommunitiesRepository::class => factory(new DoctrineRepositoryFactory(ProfileCommunityEQ::class)),
    ]
];