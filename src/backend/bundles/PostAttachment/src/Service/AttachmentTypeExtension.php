<?php
namespace PostAttachment\Service;

use PostAttachment\Entity\PostAttachment;

interface AttachmentTypeExtension
{
    public function extend(PostAttachment $postAttachment): array;
}