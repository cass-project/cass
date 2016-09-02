<?php
namespace CASS\Domain\ProfileCommunities;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use CASS\Domain\ProfileCommunities\Repository\ProfileCommunitiesRepository;

return [
    'php-di' => [
        ProfileCommunitiesRepository::class => factory(new DoctrineRepositoryFactory(ProfileCommunityEQ::class)),
    ]
];