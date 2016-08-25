<?php
namespace Domain\IM\Entity;

use CASS\Util\JSONSerializable;
use Domain\Profile\Entity\Profile;
use MongoDB\BSON\ObjectID;

class Message implements JSONSerializable
{
    /** @var ObjectID */
    private $id;

    /** @var Profile */
    private $author;

    /** @var \DateTime */
    private $dateCreated;

    /** @var string */
    private $content;

    /** @var int[] */
    private $attachmentIds = [];

    public function __construct(Profile $author, string $content, array $attachmentIds, \DateTime $dateCreated = null)
    {
        if(! $dateCreated) {
            $dateCreated = new \DateTime();
        }

        $this->author = $author;
        $this->content = $content;
        $this->attachmentIds = $attachmentIds;
        $this->dateCreated = $dateCreated;
    }

    public function toJSON(): array
    {
        $result = $this->toMongoBSON();
        unset($result['date_created_obj']);

        if($this->hasId()) {
            $result['_id'] = (string) $this->getId();
            $result['id'] = (string) $this->getId();
        }

        return $result;
    }

    public function toMongoBSON(): array
    {
        return [
            'author_id' => $this->author->getId(),
            'content' => $this->content,
            'attachment_ids' => $this->attachmentIds,
            'date_created' => $this->dateCreated->format(\DateTime::RFC2822),
            'date_created_obj' => $this->dateCreated,
        ];
    }

    public function getAuthor(): Profile
    {
        return $this->author;
    }

    public function hasId(): bool
    {
        return $this->id instanceof ObjectID;
    }

    public function getId(): ObjectID
    {
        return $this->id;
    }

    public function specifyId(ObjectID $id)
    {
        if($this->id !== null) {
            throw new \Exception('ID is already specified');
        }

        $this->id = $id;
    }

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAttachmentIds(): array
    {
        return $this->attachmentIds;
    }
}