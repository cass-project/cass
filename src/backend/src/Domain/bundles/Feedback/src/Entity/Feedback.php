<?php
namespace Domain\Feedback\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\JSONSerializable;
use Doctrine\Common\Collections\ArrayCollection;
use Domain\Feedback\Exception\EmptyDescriptionException;
use Domain\Feedback\Exception\InvalidFeedbackTypeException;
use Domain\Profile\Entity\Profile;

/**
 * @Entity(repositoryClass="Domain\Feedback\Repository\FeedbackRepository")
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
     * @ManyToOne(targetEntity="Domain\Profile\Entity\Profile")
     * @JoinColumn(name="profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $profile;

    /**
     * @OneToMany(targetEntity="Domain\Feedback\Entity\FeedbackResponse", mappedBy="feedback")
     */
    private $responses;

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

    public function __construct()
    {
        $this->responses = new ArrayCollection();
        $this->createdAt = new \DateTime();
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
            'type' => $this->type,
            'responses' => $this->hasResponses() ? array_map(function(FeedbackResponse $response) {
                return $response->toJSON();
            }, $this->responses->toArray()) : null
        ];

        if($this->hasProfile()) {
            $json['profile']['entity'] = $this->getProfile()->toJSON();
        }

        return $json;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
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

    public function setType(int $type): self
    {
        if(! in_array($type, [
            self::TYPE_COMMON_QUESTIONS,
            self::TYPE_REQUEST_ADD_THEMATIC,
            self::TYPE_SUGGESTIONS
        ])) {
            throw new InvalidFeedbackTypeException(sprintf('Invalid feedback type `%s`', $type));
        }
        
        $this->type = $type;
        return $this;
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

    public function hasResponses(): bool
    {
        return $this->responses !== null;
    }
}