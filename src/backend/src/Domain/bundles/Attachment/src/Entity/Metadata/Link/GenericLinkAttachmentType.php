<?php
namespace Domain\Attachment\Entity\Metadata\Link;

use Domain\Attachment\Entity\Metadata\LinkAttachmentType;

class GenericLinkAttachmentType implements LinkAttachmentType
{
    public function getCode()
    {
        return 'link';
    }
}