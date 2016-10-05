<?php
namespace CASS\Chat\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\JSONSerializable;

/**
 * @Entity(repositoryClass="CASS\Chat\Repository\MessageRepository")
 * @Table(name="message")
 */
class Message implements IdEntity, JSONSerializable
{

    use IdTrait;

    /**
     * @OneToOne(targetEntity="Profile")
     * @JoinColumn(name="source_profile_id", referencedColumnName="id")
     */
    private $sourceProfile;

    /**
     * @OneToOne(targetEntity="Profile")
     * @JoinColumn(name="target_profile_id", referencedColumnName="id")
     */
    private $targetProfile;

    /**
     * @Column(type="text")
     * @var string
     */
    private $message;

    /**
     * @Column(type="boolean", name="mark_as_read")
     * @var bool
     */
    private $markAsRead = false;

    /**
     * @Column(type="datetime", name="created")
     * @var \DateTime
     */
    private $created;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getSourceProfile()
    {
        return $this->sourceProfile;
    }

    public function setSourceProfile($sourceProfile)
    {
        $this->sourceProfile = $sourceProfile;
    }

    public function getTargetProfile()
    {
        return $this->targetProfile;
    }

    public function setTargetProfile($targetProfile)
    {
        $this->targetProfile = $targetProfile;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMarkAsRead()
    {
        return $this->markAsRead;
    }

    public function setMarkAsRead($markAsRead)
    {
        $this->markAsRead = $markAsRead;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }


    public function toJSON(): array
    {
        return [

        ];
    }
}