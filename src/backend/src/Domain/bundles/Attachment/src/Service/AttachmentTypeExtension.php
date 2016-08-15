<?php
namespace Domain\Attachment\Service;

use Domain\Attachment\Entity\Attachment;

interface AttachmentTypeExtension
{
    public function extend(Attachment $attachment): array;
}