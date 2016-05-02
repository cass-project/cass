<?php
namespace PostAttachment\Entity\PostAttachment\Link;

use PostAttachment\Entity\PostAttachment\LinkAttachmentType;

class GenericLinkAttachmentType implements LinkAttachmentType
{
    public function getCode() {
        return 'link';
    }
}