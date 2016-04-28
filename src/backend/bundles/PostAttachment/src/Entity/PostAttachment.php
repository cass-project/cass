<?php
namespace PostAttachment\Entity;
use Post\Entity\Post;

/**
 * @Entity(repositoryClass="PostAttachment\Repository\PostAttachmentRepository")
 * @Table(name="post_attachment")
 */
class PostAttachment
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    private $dateCreatedOn;

    /**
     * @ManyToOne(targetEntity="Post\Entity\Post")
     * @JoinColumn(name="post_id", referencedColumnName="id")
     * @var Post|null
     */
    private $post;

    /**
     * @Column(type="boolean")
     * @var bool
     */
    private $isAttachedToPost = false;

    /**
     * @Column(type="string", name="attachment_type")
     * @var string
     */
    private $attachmentType;

    /**
     * @Column(type="json_array")
     * @var \stdClass
     */
    private $attachment = (object) [];

    public function __construct(string $attachmentType, $attachment)
    {
        $this->attachmentType = $attachmentType;
        $this->attachment = $attachment;
        $this->dateCreatedOn = new \DateTime();
    }

    public function isPersisted()
    {
        return $this->id !== null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDateCreatedOn(): \DateTime
    {
        return $this->dateCreatedOn;
    }

    public function isAttachedToPost()
    {
        return $this->isAttachedToPost;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post)
    {
        $this->post = $post;
        $this->isAttachedToPost = true;
    }

    public function getAttachmentType(): string
    {
        return $this->attachmentType;
    }

    public function getAttachment()
    {
        return $this->attachment;
    }

    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
    }
}