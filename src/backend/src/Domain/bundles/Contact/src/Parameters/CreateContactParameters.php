<?php
namespace CASS\Domain\Bundles\Contact\Parameters;

final class CreateContactParameters
{
    /** @var int */
    private $profileId;

    public function __construct(int $profileId)
    {
        $this->profileId = $profileId;
    }

    public function getProfileId(): int
    {
        return $this->profileId;
    }
}