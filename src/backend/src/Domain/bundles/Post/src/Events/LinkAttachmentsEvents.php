<?php
namespace CASS\Domain\Post\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use CASS\Domain\Attachment\Entity\Attachment;
use CASS\Domain\Attachment\Service\AttachmentService;
use CASS\Domain\Post\Entity\Post;
use CASS\Domain\Post\Entity\PostAttachmentOwner;
use CASS\Domain\Post\Service\PostService;
use Evenement\EventEmitterInterface;

final class LinkAttachmentsEvents implements EventsBootstrapInterface
{
    /** @var PostService */
    private $postService;

    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService, PostService $postService)
    {
        $this->postService = $postService;
        $this->attachmentService = $attachmentService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $ps = $this->postService;
        $as = $this->attachmentService;

        $ps->getEventEmitter()->on(PostService::EVENT_CREATE, function(Post $post) use ($as, $ps) {
            if($post->hasAttachments()) {
                array_map(function(int $attachmentId) use ($post, $as, $ps) {
                    $as->attach(
                        new PostAttachmentOwner($post->getId()),
                        $as->getById($attachmentId)
                    );
                }, $post->getAttachmentIds());
            }
        });

        $ps->getEventEmitter()->on(PostService::EVENT_DELETE, function(Post $post) use ($as) {
            if($post->hasAttachments()) {
                array_map(function(Attachment $attachment) use ($as) {
                    $as->destroy($attachment);
                }, $this->attachmentService->getManyByIds($post->getAttachmentIds()));
            }
        });
    }
}