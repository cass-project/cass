<?php
namespace Domain\Feedback\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\JSONSerializable;

/**
 * @Entity(repositoryClass="Domain\Feedback\Repository\FeedbackResponseRepository")
 * @Table(name="feedback_response")
 */
class FeedbackResponse implements IdEntity, JSONSerializable
{
    use IdTrait;

    /**
     * @OneToOne(targetEntity="Domain\Feedback\Entity\Feedback")
     * @JoinColumn(name="feedback_id", referencedColumnName="id")
     * @var Feedback
     */
    private $feedback;

    /**
     * @Column(type="datetime", name="created_at")
     * @var string
     */
    private $createdAt;

    /**
     * @Column(type="string")
     * @var string
     */
    private $description;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
        $this->createdAt = new \DateTime();
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'feedback_id' => $this->getFeedback()->getId(),
            'created_at' => $this->getCreatedAt()->format(\DateTime::RFC2822),
            'description' => $this->getDescription()
        ];
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getFeedback(): Feedback
    {
        return $this->feedback;
    }
}