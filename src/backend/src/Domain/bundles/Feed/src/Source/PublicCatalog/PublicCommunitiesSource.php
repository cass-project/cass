<?php
namespace Domain\Feed\Source\PublicCatalog;

use Domain\Community\Entity\Community;
use Domain\Feed\Service\Entity;
use Domain\Feed\Source\Source;

final class PublicCommunitiesSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_communities';
    }

    public function test(Entity $entity)
    {
        return $entity instanceof Community;
    }
}