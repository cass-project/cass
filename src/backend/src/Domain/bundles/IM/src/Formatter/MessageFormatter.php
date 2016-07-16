<?php
namespace Domain\IM\Formatter;

use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Service\PostAttachmentService;
use Domain\Profile\Service\ProfileService;

final class MessageFormatter
{
    /** @var ProfileService */
    private $profileService;

    /** @var PostAttachmentService */
    private $attachmentService;

    public function __construct(ProfileService $profileService, PostAttachmentService $attachmentService)
    {
        $this->profileService = $profileService;
        $this->attachmentService = $attachmentService;
    }

    public function format(array $mongoJSON)
    {
        return array_merge($mongoJSON, [
            'author' => $this->profileService->getProfileById($mongoJSON['author_id'])->toJSON(),
            'attachments' => array_map(function(PostAttachment $attachment) {
                return $attachment->toJSON();
            }, $this->attachmentService->getAttachmentsByIds($mongoJSON['attachment_ids'])),
        ]);
    }
}