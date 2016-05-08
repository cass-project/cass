<?php
namespace Domain\PostAttachment\Service;

use Domain\PostAttachment\Entity\PostAttachment;

interface AttachmentTypeExtension
{
    public function extend(PostAttachment $postAttachment): array;
}