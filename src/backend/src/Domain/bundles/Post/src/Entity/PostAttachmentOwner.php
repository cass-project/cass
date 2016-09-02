<?php
namespace CASS\Domain\Post\Entity;

use CASS\Domain\Attachment\Entity\AttachmentOwner;

final class PostAttachmentOwner implements AttachmentOwner
{
    const OWNER_CODE = 'post';

    /** @var int */
    private $postId;

    public function __construct(int $postId)
    {
        if($postId < 0) {
            throw new \InvalidArgumentException(sprintf('Invalid ID `%s`', $postId));
        }

        $this->postId = $postId;
    }

    public function getOwnerCode(): string
    {
        return self::OWNER_CODE;
    }

    public function getId(): string
    {
        return $this->postId;
    }
}