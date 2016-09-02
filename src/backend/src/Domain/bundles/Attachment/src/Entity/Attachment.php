<?php
namespace CASS\Domain\Bundles\Attachment\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\Entity\SIDEntity\SIDEntity;
use CASS\Util\Entity\SIDEntity\SIDEntityTrait;
use CASS\Util\JSONSerializable;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Attachment\Repository\AttachmentRepository")
 * @Table(name="attachment")
 */
class Attachment implements JSONSerializable, IdEntity, SIDEntity
{
    use IdTrait;
    use SIDEntityTrait;

    /**
     * @Column(type="datetime", name="date_created_on")
     * @var \DateTime
     */
    private $dateCreatedOn;

    /**
     * @Column(type="datetime", name="date_attached_on")
     * @var \DateTime
     */
    private $dateAttachedOn;

    /**
     * @Column(type="boolean", name="is_attached")
     * @var bool
     */
    private $isAttached = false;

    /**
     * @Column(type="string", name="owner_id")
     * @var int
     */
    private $ownerId;

    /**
     * @Column(type="string", name="owner_code")
     * @var string
     */
    private $ownerCode;

    /**
     * @Column(type="json_array", name="metadata")
     * @var array
     */
    private $metadata = [];

    public function __construct()
    {
        $this->regenerateSID();
        $this->dateCreatedOn = new \DateTime();
    }

    public function toJSON(): array
    {
        $result = [
            'id' => $this->isPersisted() ? $this->getId() : '#NEW_ATTACHMENT',
            'sid' => $this->getSID(),
            'date_created_on' => $this->getDateCreatedOn()->format(\DateTime::RFC2822),
            'metadata' => $this->getMetadata(),
            'is_attached' => $this->isAttached(),
        ];

        if($this->isAttached()) {
            $result = array_merge($result, [
                'date_attached_on' => $this->getDateAttachedOn()->format(\DateTime::RFC2822),
                'owner' => [
                    'id' => $this->getOwnerId(),
                    'code' => $this->getOwnerCode(),
                ],
            ]);
        }

        return $result;
    }

    public function getDateCreatedOn(): \DateTime
    {
        return $this->dateCreatedOn;
    }

    public function attach(AttachmentOwner $owner): self
    {
        $this->isAttached = true;
        $this->dateAttachedOn = new \DateTime();
        $this->ownerId = $owner->getId();
        $this->ownerCode = $owner->getOwnerCode();

        return $this;
    }

    public function detach(): self
    {
        $this->isAttached = false;
        $this->dateAttachedOn = null;

        return $this;
    }

    public function isAttached()
    {
        return $this->isAttached;
    }

    public function getOwnerCode(): string
    {
        return $this->ownerCode;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getDateAttachedOn(): \DateTime
    {
        return $this->dateAttachedOn;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    public function mergeMetadata(array $extends): self
    {
        $this->metadata = array_merge_recursive($this->metadata, $extends);

        return $this;
    }
}