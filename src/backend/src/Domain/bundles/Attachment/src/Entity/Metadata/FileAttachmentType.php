<?php
namespace CASS\Domain\Attachment\Entity\Metadata;

interface FileAttachmentType extends AttachmentType
{
    public function getMinFileSizeBytes();

    public function getMaxFileSizeBytes();
}