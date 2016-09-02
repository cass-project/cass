<?php
namespace CASS\Domain\Attachment\Entity\Metadata\Link;

use CASS\Domain\Attachment\Entity\Metadata\LinkAttachmentType;

class GenericLinkAttachmentType implements LinkAttachmentType
{
    public function getCode()
    {
        return 'link';
    }
}