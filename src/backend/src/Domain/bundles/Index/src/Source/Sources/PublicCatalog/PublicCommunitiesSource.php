<?php
namespace Domain\Index\Source\Sources\PublicCatalog;

use Domain\Community\Entity\Community;
use Domain\Index\Source\Source;

final class PublicCommunitiesSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_communities';
    }
}