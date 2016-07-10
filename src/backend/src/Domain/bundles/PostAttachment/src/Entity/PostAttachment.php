<?php
namespace Domain\PostAttachment\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\Entity\SIDEntity\SIDEntity;
use Application\Util\Entity\SIDEntity\SIDEntityTrait;
use Application\Util\JSONSerializable;
use Domain\Post\Entity\Post;

/**
 * @Entity(repositoryClass="Domain\PostAttachment\Repository\PostAttachmentRepository")
 * @Table(name="post_attachment")
 */
class PostAttachment implements JSONSerializable, IdEntity, SIDEntity
{
    use IdTrait;
    use SIDEntityTrait;

    /**
     * @Column(type="datetime", name="date_created_on")
     * @var \DateTime
     */
    private $dateCreatedOn;

    /**
     * @ManyToOne(targetEntity="Domain\Post\Entity\Post")
     * @JoinColumn(name="post_id", referencedColumnName="id")
     * @var Post|null
     */
    private $post;

    /**
     * @Column(type="boolean", name="is_attached_to_post")
     * @var bool
     */
    private $isAttachedToPost = false;

    /**
     * @deprecated
     * @Column(type="string", name="attachment_type")
     * @var string
     */
    private $attachmentType = 'link';

    /**
     * @Column(type="json_array")
     * @var array
     */
    private $attachment = [];

    public function __construct() {
        $this->regenerateSID();
        $this->dateCreatedOn = new \DateTime();
    }

    public function toJSON(): array {
        return [
            'id' => $this->isPersisted() ? $this->getId() : '#NEW_POST_ATTACHMENT',
            'sid' => $this->getSID(),
            'date_created_on' => $this->getDateCreatedOn()->format(\DateTime::RFC2822),
            'is_attached_to_post' => $this->isAttachedToPost(),
            'post_id' => $this->isAttachedToPost() ? $this->getPost()->getId() : null,
            'attachment_type' => $this->getAttachmentType(),
            'attachment' => $this->getAttachment()
        ];
    }

    public function getDateCreatedOn(): \DateTime {
        return $this->dateCreatedOn;
    }

    public function isAttachedToPost() {
        return $this->isAttachedToPost;
    }

    public function getPost(): Post {
        return $this->post;
    }

    public function attachToPost(Post $post) {
        $this->post = $post;
        $this->isAttachedToPost = true;
    }

    public function getAttachmentType(): string {
        return $this->attachmentType;
    }

    public function getAttachment(): array {
        return $this->attachment;
    }

    public function setAttachment($attachment) {
        $this->attachment = $attachment;
    }

    public function mergeAttachment(array $extends): self {
        $this->attachment = array_merge_recursive($this->attachment, $extends);
        return $this;
    }
}