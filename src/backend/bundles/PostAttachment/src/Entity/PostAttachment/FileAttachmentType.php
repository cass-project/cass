<?php
namespace PostAttachment\Entity\PostAttachment;

interface FileAttachmentType extends AttachmentType
{
    public function getMinFileSizeBytes();
    public function getMaxFileSizeBytes();
}