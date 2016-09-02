<?php
namespace CASS\Domain\Index\Source\Sources;

use CASS\Domain\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class CommunitySource implements Source
{
    /** @var int */
    private $communityId;

    public function __construct(int $communityId)
    {
        $this->communityId = $communityId;
    }

    public function getCommunityId(): int
    {
        return $this->communityId;
    }

    public function getMongoDBCollection(): string
    {
        return sprintf('community_feed_%d', $this->communityId);
    }

    public function ensureIndexes(Database $database, Collection $collection)
    {
        $collection->createIndex(['title' => 'text']);
    }
}