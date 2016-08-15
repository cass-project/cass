<?php
namespace Domain\Attachment\Entity\Metadata\File;

use Domain\Attachment\Entity\Metadata\FileAttachmentType;

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