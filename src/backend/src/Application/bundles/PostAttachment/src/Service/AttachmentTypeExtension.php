<?php
namespace Application\PostAttachment\Service;

use Application\PostAttachment\Entity\PostAttachment;

interface AttachmentTypeExtension
{
    public function extend(PostAttachment $postAttachment): array;
}