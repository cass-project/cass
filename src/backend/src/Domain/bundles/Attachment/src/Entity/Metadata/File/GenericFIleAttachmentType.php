<?php
namespace CASS\Domain\Bundles\Attachment\Entity\Metadata\File;

use CASS\Domain\Bundles\Attachment\Entity\Metadata\FileAttachmentType;

class GenericFileAttachmentType implements FileAttachmentType
{
    public function getCode()
    {
        return 'file';
    }

    public function getMinFileSizeBytes()
    {
        return 1;
    }

    public function getMaxFileSizeBytes()
    {
        return 1024*32;
    }
}