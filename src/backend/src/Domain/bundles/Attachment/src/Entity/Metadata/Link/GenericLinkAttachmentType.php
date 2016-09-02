<?php
namespace CASS\Domain\Bundles\Attachment\Entity\Metadata\Link;

use CASS\Domain\Bundles\Attachment\Entity\Metadata\LinkAttachmentType;

class GenericLinkAttachmentType implements LinkAttachmentType
{
    public function getCode()
    {
        return 'link';
    }
}