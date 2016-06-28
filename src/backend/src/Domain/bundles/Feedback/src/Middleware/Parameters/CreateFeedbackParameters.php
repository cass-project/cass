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
    
    /** @var string */
    private $email;
    
    public function __construct(
        string $type,
        string $description,
        int $profileId = null,
        string $email = null
    ) {
        $this->type = $type;
        $this->description = $description;
        $this->profileId = $profileId;
        $this->email = $email;
    }

    public function getProfileId(): int
    {
        return $this->profileId;
    }

    public function hasProfile(): bool
    {
        return $this->profileId != null;
    }

    public function hasEmail(): bool
    {
        return $this->email !== null;
    }

    public function getEmail(): string
    {
        return $this->email;
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