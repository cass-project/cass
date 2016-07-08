<?php
namespace Domain\PostAttachment\Formatter;

use Domain\PostAttachment\Entity\PostAttachment;

final class PostAttachmentFormatter
{
    public function format(PostAttachment $postAttachment)
    {
        return [
            'entity' => $postAttachment->toJSON()
        ];
    }
}