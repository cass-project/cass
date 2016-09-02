<?php
namespace CASS\Domain\Bundles\Index\Source\Sources\PublicCatalog;

use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class PublicCommunitiesSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_communities';
    }

    public function ensureIndexes(Database $database, Collection $collection)
    {
        $collection->createIndex(['title' => 'text']);
    }

}