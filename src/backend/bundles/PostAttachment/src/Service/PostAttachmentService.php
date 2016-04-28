<?php
namespace PostAttachment\Service;

use Common\Exception\NotImplementedException;
use PostAttachment\Entity\PostAttachment;

class PostAttachmentService
{
    public function uploadAttachment(string $tmpFile): PostAttachment {
        throw new NotImplementedException;
    }
}