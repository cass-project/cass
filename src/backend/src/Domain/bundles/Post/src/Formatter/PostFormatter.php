<?php
namespace CASS\Domain\Bundles\Post\Formatter;

use CASS\Domain\Bundles\Attachment\Entity\Attachment;
use CASS\Domain\Bundles\Attachment\Formatter\AttachmentFormatter;
use CASS\Domain\Bundles\Attachment\Service\AttachmentService;
use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Service\LikePostService;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Post\PostType\PostTypeFactory;
use CASS\Domain\Bundles\Post\Service\PostService;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;

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

    /** @var CurrentIPServiceInterface  */
    private $currentIPService;

    /** @var PostService  */
    private $postService;

    /** @var CurrentAccountService  */
    private $currentAccountService;

    private $likePostService;

    public function __construct(
        ProfileService $profileService, 
        PostTypeFactory $postTypeFactory, 
        AttachmentService $attachmentService, 
        AttachmentFormatter $attachmentFormatter,
        CurrentIPServiceInterface $currentIPService,
        PostService $postService,
        CurrentAccountService $currentAccountService,
        LikePostService $likePostService
    ) {
        $this->profileService = $profileService;
        $this->postTypeFactory = $postTypeFactory;
        $this->attachmentService = $attachmentService;
        $this->attachmentFormatter = $attachmentFormatter;
        $this->currentIPService = $currentIPService;
        $this->postService = $postService;
        $this->currentAccountService = $currentAccountService;
        $this->likePostService = $likePostService;
    }

    public function format(Post $post): array
    {
        $postTypeObject = $this->postTypeFactory->createPostTypeByIntCode($post->getPostTypeCode());

        $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
        $attitude = $attitudeFactory->getAttitude();
        $attitude->setResource($post);

        $attitudeState = 'none';
        if($this->likePostService->isAttitudeExists($attitude)) {
            $attitude = $this->likePostService->getAttitude($attitude);
            $attitudeState = $attitude->getAttitudeType() === Attitude::ATTITUDE_TYPE_LIKE ? 'liked' : 'disliked';
        }

        return array_merge_recursive($post->toJSON(), [
            'post_type' => $postTypeObject->toJSON(),
            'profile' => $this->profileService->getProfileById($post->getAuthorProfile()->getId())->toJSON(),
            'attachments' => $this->formatAttachments($post),
            'attitude' => [
                'state' => $attitudeState,
                'likes' => $post->getLikes(),
                'dislikes' => $post->getDislikes(),
            ],
        ]);
    }

    private function formatAttachments(Post $post): array
    {
        return array_map(function(Attachment $attachment) {
            return $this->attachmentFormatter->format($attachment);
        }, $this->attachmentService->getManyByIds($post->getAttachmentIds()));
    }
}