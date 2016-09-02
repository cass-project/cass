<?php
namespace CASS\Domain\Index\Source\Sources\PublicCatalog;

use CASS\Domain\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class PublicCollectionsSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_collections';
    }

    public function ensureIndexes(Database $database, Collection $collection)
    {
        $collection->createIndex(['title' => 'text']);
    }
}