<?php
namespace Domain\Index\Source\Sources\PublicCatalog;

use Domain\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class PublicDiscussionsSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_discussions';
    }

    public function ensureIndexes(Database $database, Collection $collection)
    {
        $collection->createIndex(['content' => 'text']);
    }
}