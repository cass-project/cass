<?php
namespace CASS\Domain\Bundles\Attachment\Formatter;

use CASS\Domain\Bundles\Attachment\Entity\Attachment;

final class AttachmentFormatter
{
    public function format(Attachment $attachment)
    {
        return $attachment->toJSON();
    }
}