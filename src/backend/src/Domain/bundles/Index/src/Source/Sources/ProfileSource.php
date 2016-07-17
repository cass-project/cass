<?php
namespace Domain\Index\Source\Sources;

use Domain\Feed\Source\Source;

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
}