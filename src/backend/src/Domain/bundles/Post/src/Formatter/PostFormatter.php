<?php
namespace Domain\Post\Formatter;

use Domain\Post\Entity\Post;
use Domain\Post\PostType\PostTypeFactory;
use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Formatter\PostAttachmentFormatter;
use Domain\PostAttachment\Service\PostAttachmentService;

final class PostFormatter
{
    /** @var PostTypeFactory */
    private $postTypeFactory;

    /** @var PostAttachmentService */
    private $postAttachmentService;

    /** @var PostAttachmentFormatter */
    private $postAttachmentFormatter;

    public function __construct(
        PostTypeFactory $postTypeFactory,
        PostAttachmentService $postAttachmentService,
        PostAttachmentFormatter $postAttachmentFormatter)
    {
        $this->postTypeFactory = $postTypeFactory;
        $this->postAttachmentService = $postAttachmentService;
        $this->postAttachmentFormatter = $postAttachmentFormatter;
    }

    public function format(Post $post): array
    {
        $postTypeObject = $this->postTypeFactory->createPostTypeByIntCode($post->getPostTypeCode());

        return array_merge_recursive($post->toJSON(), [
            'post_type' => $postTypeObject->toJSON(),
            'attachments' => $this->formatAttachments($post)
        ]);
    }

    private function formatAttachments(Post $post): array
    {
        return array_map(function(PostAttachment $postAttachment) {
            return $this->postAttachmentFormatter->format($postAttachment);
        }, $this->postAttachmentService->getAttachmentsOfPost($post->getId()));
    }
}