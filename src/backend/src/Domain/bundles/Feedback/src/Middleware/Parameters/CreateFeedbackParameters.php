<?php
namespace Domain\Feedback\Middleware\Parameters;

class CreateFeedbackParameters
{
    /** @var int */
    private $profileId;

    /** @var string string */
    private $type;

    /** @var string */
    private $description;

    public function __construct(string $type, string $description, int $profileId = null)
    {
        $this->type = $type;
        $this->profileId = $profileId;
        $this->description = $description;
    }

    public function getProfileId(): int
    {
        return $this->profileId;
    }

    public function hasProfile(): bool
    {
        return $this->profileId != null;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}