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

    const SOURCE_TYPE_PROFILE = 1;
    const TARGET_TYPE_PROFILE = 1;

    /**
     * @Column(type="integer", name="source_type")
     * @var int
     */
    private $sourceType;

    /**
     * @Column(type="integer", name="source_id")
     * @var int
     */
    private $sourceId;

    /**
     * @Column(type="integer", name="target_type")
     * @var int
     */
    private $targetType;

    /**
     * @Column(type="integer", name="target_id")
     * @var int
     */
    private $targetId;

    /**
     * @Column(type="text")
     * @var string
     */
    private $content;

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

    private $attachments = [];

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getTargetType()
    {
        return $this->targetType;
    }

    public function setTargetType(int $targetType)
    {
        $this->targetType = $targetType;
        return $this;
    }

    public function getTargetId(): int
    {
        return $this->targetId;
    }

    public function setTargetId(int $targetId)
    {
        $this->targetId = $targetId;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
        return $this;
    }

    public function getSourceType(): int
    {
        return $this->sourceType;
    }

    public function setSourceType(int $sourceType)
    {
        $this->sourceType = $sourceType;
        return $this;
    }

    public function getSourceId(): int
    {
        return $this->sourceId;
    }

    public function setSourceId(int $sourceId)
    {
        $this->sourceId = $sourceId;
        return $this;
    }

    public function getMarkAsRead(): bool
    {
        return $this->markAsRead;
    }

    public function setMarkAsRead(bool $markAsRead)
    {
        $this->markAsRead = $markAsRead;
        return $this;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    public function toJSON(): array
    {
        return [

        ];
    }
}