<?php
namespace CASS\Domain\Attachment\Service;

use CASS\Domain\Attachment\Entity\Attachment;

interface AttachmentTypeExtension
{
    public function extend(Attachment $attachment): array;
}