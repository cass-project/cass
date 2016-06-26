<?php
namespace Domain\Feedback\Middleware\Parameters;

class CreateFeedbackResponseParameters
{
    /** @var int */
    private $feedbackId;

    /** @var \DateTime */
    private $createdAt;

    /** @var string */
    private $description;

    public function __construct(string $description, int $feedbackId)
    {
        $this->createdAt = new \DateTime();
        $this->feedbackId = $feedbackId;
        $this->description = $description;
    }

    public function getFeedbackId(): int
    {
        return $this->feedbackId;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

}