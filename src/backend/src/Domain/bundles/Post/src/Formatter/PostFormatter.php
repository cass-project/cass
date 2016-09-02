<?php
namespace CASS\Domain\Post\Formatter;

use CASS\Domain\Attachment\Entity\Attachment;
use CASS\Domain\Attachment\Formatter\AttachmentFormatter;
use CASS\Domain\Attachment\Service\AttachmentService;
use CASS\Domain\Post\Entity\Post;
use CASS\Domain\Post\PostType\PostTypeFactory;
use CASS\Domain\Profile\Service\ProfileService;

final class PostFormatter
{
    /** @var ProfileService */
    private $profileService;

    /** @var PostTypeFactory */
    private $postTypeFactory;

    /** @var AttachmentService */
    private $attachmentService;

    /** @var AttachmentFormatter */
    private $attachmentFormatter;

    public function __construct(
        ProfileService $profileService, 
        PostTypeFactory $postTypeFactory, 
        AttachmentService $attachmentService, 
        AttachmentFormatter $attachmentFormatter
    ) {
        $this->profileService = $profileService;
        $this->postTypeFactory = $postTypeFactory;
        $this->attachmentService = $attachmentService;
        $this->attachmentFormatter = $attachmentFormatter;
    }

    public function format(Post $post): array
    {
        $postTypeObject = $this->postTypeFactory->createPostTypeByIntCode($post->getPostTypeCode());

        return array_merge_recursive($post->toJSON(), [
            'post_type' => $postTypeObject->toJSON(),
            'profile' => $this->profileService->getProfileById($post->getAuthorProfile()->getId())->toJSON(),
            'attachments' => $this->formatAttachments($post)
        ]);
    }

    private function formatAttachments(Post $post): array
    {
        return array_map(function(Attachment $attachment) {
            return $this->attachmentFormatter->format($attachment);
        }, $this->attachmentService->getManyByIds($post->getAttachmentIds()));
    }
}