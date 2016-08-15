<?php
namespace Domain\Attachment\Formatter;

use Domain\Attachment\Entity\Attachment;

final class AttachmentFormatter
{
    public function format(Attachment $attachment)
    {
        return $attachment->toJSON();
    }
}