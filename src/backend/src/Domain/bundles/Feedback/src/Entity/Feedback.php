<?php
namespace CASS\Domain\Bundles\Feedback\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\JSONSerializable;
use CASS\Domain\Bundles\Feedback\Exception\EmptyDescriptionException;
use CASS\Domain\Bundles\Feedback\FeedbackType\FeedbackType;
use CASS\Domain\Bundles\Profile\Entity\Profile;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Feedback\Repository\FeedbackRepository")
 * @Table(name="feedback")
 */
class Feedback implements JSONSerializable, IdEntity
{
    use IdTrait;

    const TYPE_COMMON_QUESTIONS = 1;
    const TYPE_REQUEST_ADD_THEMATIC = 2;
    const TYPE_SUGGESTIONS = 3;

    /**
     * @Column(type="datetime", name="created_at")
     * @var string
     */
    private $createdAt;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Bundles\Profile\Entity\Profile")
     * @JoinColumn(name="profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $profile;

    /**
     * @OneToOne(targetEntity="CASS\Domain\Bundles\Feedback\Entity\FeedbackResponse", cascade={"all"})
     * @JoinColumn(name="answer_id", referencedColumnName="id")
     * @var FeedbackResponse
     */
    private $response;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $type;

    /**
     * @Column(type="string")
     * @var string
     */
    private $description;

    /**
     * @Column(type="boolean", name="feedback_read")
     * @var bool
     */
    private $read = false;

    /**
     * @Column(type="string")
     * @var string
     */
    private $email;

    public function __construct(FeedbackType $feedbackType, string $description, Profile $profile = null)
    {
        $this->type = $feedbackType->getIntCode();
        $this->createdAt = new \DateTime();
        $this->profile = $profile;
        $this->setDescription($description);
    }

    public function toJSON(): array
    {
        $json = [
            'id' => $this->id,
            'created_at' => $this->createdAt->format(\DateTime::RFC2822),
            'description' => $this->description,
            'profile' => [
                'has' => $this->hasProfile()
            ],
            'email' => [
                'has' => $this->hasEmail()
            ],
            'type' => $this->type,
            'read' => $this->read,
            'answer' => [
                'has' => $this->hasResponse()
            ]
        ];

        if($this->hasProfile()) {
            $json['profile']['entity'] = $this->getProfile()->toJSON();
        }

        if($this->hasEmail()) {
            $json['email']['contact'] = $this->getEmail();
        }

        if($this->hasResponse()) {
            $json['answer']['entity'] = $this->getResponse()->toJSON();
        }

        return $json;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function hasProfile(): bool
    {
        return $this->profile !== null;
    }

    public function setProfile(Profile $profile = null): self
    {
        $this->profile = $profile;
        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $description = trim($description);

        if(! strlen($description)) {
            throw new EmptyDescriptionException('No feedback description');
        }

        $this->description = $description;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function hasEmail(): bool
    {
        return $this->email !== null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function hasResponse(): bool
    {
        return ($this->response instanceof FeedbackResponse);
    }

    public function getResponse(): FeedbackResponse
    {
        return $this->response;
    }

    public function specifyResponse(FeedbackResponse $answer): self
    {
        if($this->hasResponse()) {
            throw new \Exception('Feedback already has an answer');
        }

        $this->response = $answer;

        return $this;
    }

    public function markAsRead(): self
    {
        $this->read = true;

        return $this;
    }

    public function unmarkAsRead(): self
    {
        $this->read = false;

        return $this;
    }
}