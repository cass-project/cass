<?php
namespace CASS\Domain\Community\Parameters;

class SetPublicOptionsParameters
{
    /** @var bool */
    private $publicEnabled;

    /** @var bool */
    private $moderationContract;

    public function __construct(bool $publicEnabled, bool $moderationContract)
    {
        $this->publicEnabled = $publicEnabled;
        $this->moderationContract = $moderationContract;
    }

    public function isPublicEnabled(): bool
    {
        return $this->publicEnabled;
    }

    public function isModerationContract(): bool
    {
        return $this->moderationContract;
    }
}