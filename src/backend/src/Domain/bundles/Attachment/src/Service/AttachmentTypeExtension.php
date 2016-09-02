<?php
namespace CASS\Domain\Bundles\Attachment\Service;

use CASS\Domain\Bundles\Attachment\Entity\Attachment;

interface AttachmentTypeExtension
{
    public function extend(Attachment $attachment): array;
}