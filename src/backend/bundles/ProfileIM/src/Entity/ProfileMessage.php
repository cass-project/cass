<?php
namespace ProfileIM\Entity;

use Profile\Entity\Profile;
use \Datetime;

class MessageIsNotReadException extends \Exception {}

/**
 * @Entity(repositoryClass="ProfileIM\Repository\ProfileMessageRepository")
 * @Table(name="profile_message")
 */
class ProfileMessage
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Profile\Entity\Profile")
     * @JoinColumn(name="source_profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $sourceProfile;

    /**
     * @ManyToOne(targetEntity="Profile\Entity\Profile")
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
    private $content = "";

    public function __construct(Profile $sourceProfile, Profile $targetProfile)
    {
        $this->sourceProfile = $sourceProfile;
        $this->targetProfile = $targetProfile;
        $this->dateCreated = new \DateTime();
    }

    public function isPersisted()
    {
        return $this->id !== null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSourceProfile(): Profile
    {
        return $this->sourceProfile;
    }

    public function getTargetProfile(): Profile
    {
        return $this->targetProfile;
    }

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    public function getDateRead(): DateTime
    {
        if(! $this->isRead()) {
            throw new MessageIsNotReadException(sprintf('Message with id `%s` is not read', $this->getId()));
        }

        return $this->dateRead;
    }

    public function isRead(): bool
    {
        return $this->isRead;
    }

    public function setAsRead()
    {
        $this->isRead = true;
        $this->dateRead = new DateTime();
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return ProfileMessage
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}