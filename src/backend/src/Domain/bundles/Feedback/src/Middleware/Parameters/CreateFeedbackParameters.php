<?php
namespace Domain\Feedback\Middleware\Parameters;

class CreateFeedbackParameters
{
    /** @var \DateTime */
    private $createdAt;

    /** @var int */
    private $profileId;

    /** @var string string */
    private $type;

    /** @var string */
    private $description;

    public function __construct(string $type, string $description, int $profileId = null)
    {
        $this->createdAt = new \DateTime();
        $this->type = $type;
        $this->profileId = $profileId;
        $this->description = $description;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
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