<?php
namespace Domain\Index\Source\Sources;

use Domain\Index\Source\Source;

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
}