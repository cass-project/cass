<?php
namespace Domain\ProfileIM\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\JSONSerializable;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;
use Domain\ProfileIM\Exception\MessageIsNotReadException;

/**
 * @Entity(repositoryClass="Domain\ProfileIM\Repository\ProfileMessageRepository")
 * @Table(name="profile_message")
 */
class ProfileMessage implements JSONSerializable, IdEntity
{
    use IdTrait;

    /**
     * @ManyToOne(targetEntity="Domain\Profile\Entity\Profile")
     * @JoinColumn(name="source_profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $sourceProfile;

    /**
     * @ManyToOne(targetEntity="Domain\Profile\Entity\Profile")
     * @JoinColumn(name="target_profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $targetProfile;

    /**
     * @Column(type="datetime", name="date_created")
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @Column(type="datetime", name="date_read")
     * @var \DateTime
     */
    private $dateRead;

    /**
     * @Column(type="boolean", name="is_read")
     * @var bool
     */
    private $isRead = false;

    /**
     * @Column(type="text")
     * @var string
     */
    private $content;

    public function __construct(Profile $sourceProfile, Profile $targetProfile) {
        $this->sourceProfile = $sourceProfile;
        $this->targetProfile = $targetProfile;
        $this->dateCreated = new \DateTime();
    }

    public function toJSON(): array {
        return [
            'id' => $this->id,
            'source_profile_id' => $this->getSourceProfile()->getId(),
            'target_profile_id' => $this->getTargetProfile()->getId(),
            'date_created_on' => $this->getDateCreated()->format('Y-m-d H:i:s'),
            'read_status' => [
                'is_read' => $this->isRead,
                'date_read' => $this->isRead ? $this->getDateRead()->format('Y-m-d H:i:s') : NULL
            ],
            'content' => $this->getContent(),
        ];
    }

    public function getSourceProfile(): Profile {
        return $this->sourceProfile;
    }

    public function getTargetProfile(): Profile {
        return $this->targetProfile;
    }

    public function getDateCreated(): \DateTime {
        return $this->dateCreated;
    }

    public function getDateRead(): \DateTime {
        if (!$this->isRead()) {
            throw new MessageIsNotReadException(sprintf('Message with id `%s` is not read', $this->getId()));
        }

        return $this->dateRead;
    }

    public function isRead(): bool {
        return $this->isRead;
    }

    public function setAsRead() {
        $this->isRead = true;
        $this->dateRead = new \DateTime();
        return $this;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function setContent(string $content): self {
        $this->content = $content;
        return $this;
    }
}