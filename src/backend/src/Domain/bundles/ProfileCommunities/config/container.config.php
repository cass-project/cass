<?php
namespace CASS\Domain\Bundles\ProfileCommunities;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Bundles\ProfileCommunities\Entity\ProfileCommunityEQ;
use CASS\Domain\Bundles\ProfileCommunities\Repository\ProfileCommunitiesRepository;

return [
    'php-di' => [
        ProfileCommunitiesRepository::class => factory(new DoctrineRepositoryFactory(ProfileCommunityEQ::class)),
    ]
];