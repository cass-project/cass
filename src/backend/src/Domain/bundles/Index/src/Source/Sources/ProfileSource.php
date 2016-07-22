<?php
namespace Domain\Index\Source\Sources;

use Domain\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class ProfileSource implements Source
{
    /** @var int */
    private $profileId;

    public function __construct(int $profileId)
    {
        $this->profileId = $profileId;
    }

    public function getMongoDBCollection(): string
    {
        return sprintf('profile_feed_%d', $this->profileId);
    }

    public function ensureIndexes(Database $database, Collection $collection)
    {
    }
}