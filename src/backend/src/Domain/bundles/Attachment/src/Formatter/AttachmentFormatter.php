<?php
namespace CASS\Domain\Attachment\Formatter;

use CASS\Domain\Attachment\Entity\Attachment;

final class AttachmentFormatter
{
    public function format(Attachment $attachment)
    {
        return $attachment->toJSON();
    }
}