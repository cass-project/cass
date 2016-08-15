<?php
namespace Domain\IM\Formatter;

use Domain\Attachment\Entity\Attachment;
use Domain\Attachment\Service\AttachmentService;
use Domain\Profile\Service\ProfileService;

final class MessageFormatter
{
    /** @var ProfileService */
    private $profileService;

    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(ProfileService $profileService, AttachmentService $attachmentService)
    {
        $this->profileService = $profileService;
        $this->attachmentService = $attachmentService;
    }

    public function format(array $mongoJSON)
    {
        return array_merge($mongoJSON, [
            'author' => $this->profileService->getProfileById($mongoJSON['author_id'])->toJSON(),
            'attachments' => array_map(function(Attachment $attachment) {
                return $attachment->toJSON();
            }, $this->attachmentService->getManyByIds($mongoJSON['attachment_ids'])),
        ]);
    }
}