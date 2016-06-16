<?php
namespace Domain\Collection\Parameters;

class SetPublicOptionsParameters
{
    /** @var bool */
    private $isPrivate;

    /** @var bool */
    private $publicEnabled;

    /** @var bool */
    private $moderationContact;

    public function __construct(bool $isPrivate, bool $publicEnabled, bool $moderationContact)
    {
        $this->isPrivate = $isPrivate;
        $this->publicEnabled = $publicEnabled;
        $this->moderationContact = $moderationContact;
    }

    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    public function isPublicEnabled(): bool
    {
        return $this->publicEnabled;
    }

    public function isModerationContractEnabled(): bool
    {
        return $this->moderationContact;
    }
}