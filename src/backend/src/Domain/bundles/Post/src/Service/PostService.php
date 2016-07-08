<?php
namespace Domain\Post\Service;

use Application\Exception\NotImplementedException;
use Application\Service\EventEmitterAware\EventEmitterAwareService;
use Application\Service\EventEmitterAware\EventEmitterAwareTrait;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Service\CollectionService;
use Domain\Post\Entity\Post;
use Domain\Post\Parameters\CreatePostParameters;
use Domain\Post\Parameters\EditPostParameters;
use Domain\Post\PostType\PostTypeFactory;
use Domain\Post\Repository\PostRepository;
use Domain\PostAttachment\Service\PostAttachmentService;
use Domain\Profile\Service\ProfileService;

class PostService implements EventEmitterAwareService
{
    use EventEmitterAwareTrait;

    const EVENT_CREATE = 'domain.post.create';
    const EVENT_EDIT = 'domain.post.edit';
    const EVENT_DELETE = 'domain.post.delete';
    const EVENT_DELETED = 'domain.post.deleted';

    /** @var PostAttachmentService */
    private $postAttachmentService;

    /** @var PostRepository */
    private $postRepository;

    /** @var PostTypeFactory */
    private $postTypeFactory;
    
    /** @var ProfileService */
    private $profileService;
    
    /** @var CollectionService */
    private $collectionService;

    public function __construct(
        PostAttachmentService $postAttachmentService,
        PostRepository $postRepository,
        PostTypeFactory $postTypeFactory,
        ProfileService $profileService,
        CollectionService $collectionService
    ) {
        $this->postAttachmentService = $postAttachmentService;
        $this->postRepository = $postRepository;
        $this->postTypeFactory = $postTypeFactory;
        $this->profileService = $profileService;
        $this->collectionService = $collectionService;
    }

    public function createPost(CreatePostParameters $createPostParameters): Post
    {
        $postType = $this->postTypeFactory->createPostTypeByIntCode($createPostParameters->getPostTypeCode());
        $collection = $this->collectionService->getCollectionById($createPostParameters->getCollectionId());
        $profile = $this->profileService->getProfileById($createPostParameters->getProfileId());
        
        $post = new Post($postType, $profile, $collection, $createPostParameters->getContent());

        $this->postRepository->createPost($post);
        $this->getEventEmitter()->emit(self::EVENT_CREATE, [$post]);

        return $post;
    }

    public function editPost(EditPostParameters $editPostParameters): Post
    {
        throw new NotImplementedException;
    }

    public function deletePost(int $postId)
    {
        throw new NotImplementedException;
    }

    public function getPostById(int $postId): Post
    {
        return $this->postRepository->getPost($postId);
    }
}