<?php
namespace Application\PostAttachment\Entity\PostAttachment\Link;

use Application\PostAttachment\Entity\PostAttachment\LinkAttachmentType;

class GenericLinkAttachmentType implements LinkAttachmentType
{
    public function getCode() {
        return 'link';
    }
}