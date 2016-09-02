<?php
namespace CASS\Domain\Index\Source\Sources;

use CASS\Domain\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class CollectionSource implements Source
{
    /** @var int */
    private $collectionId;

    public function __construct(int $collectionId)
    {
        $this->collectionId = $collectionId;
    }

    public function getMongoDBCollection(): string
    {
        return sprintf('collection_feed_%d', $this->collectionId);
    }

    public function ensureIndexes(Database $database, Collection $collection)
    {
        $collection->createIndex(['title' => 'text']);
    }
}