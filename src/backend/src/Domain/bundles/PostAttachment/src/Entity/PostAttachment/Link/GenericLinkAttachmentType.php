<?php
namespace Domain\PostAttachment\Entity\PostAttachment\Link;

use Domain\PostAttachment\Entity\PostAttachment\LinkAttachmentType;

class GenericLinkAttachmentType implements LinkAttachmentType
{
    public function getCode() {
        return 'link';
    }
}