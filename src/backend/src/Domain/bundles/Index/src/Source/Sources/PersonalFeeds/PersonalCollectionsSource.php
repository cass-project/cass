<?php
namespace CASS\Domain\Bundles\Index\Source\Sources\PersonalFeeds;

use CASS\Domain\Bundles\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class PersonalCollectionsSource implements Source
{
    /** @var int */
    private $profileId;

    public function __construct($profileId)
    {
        $this->profileId = $profileId;
    }

    public function getMongoDBCollection(): string
    {
        return sprintf('personal_collections_%d', $this->profileId);
    }

    public function ensureIndexes(Database $database, Collection $collection)
    {
    }
}