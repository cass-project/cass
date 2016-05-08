<?php
namespace Domain\PostAttachment\Entity\PostAttachment\File;

use Domain\PostAttachment\Entity\PostAttachment\FileAttachmentType;

class GenericFileAttachmentType implements FileAttachmentType
{
    public function getCode() {
        return 'file';
    }

    public function getMinFileSizeBytes() {
        return 1;
    }

    public function getMaxFileSizeBytes() {
        return 1024*32;
    }
}