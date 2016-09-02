<?php
namespace CASS\Domain\Bundles\Post\Service;

use CASS\Application\Service\EventEmitterAware\EventEmitterAwareService;
use CASS\Application\Service\EventEmitterAware\EventEmitterAwareTrait;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Post\Parameters\CreatePostParameters;
use CASS\Domain\Bundles\Post\Parameters\EditPostParameters;
use CASS\Domain\Bundles\Post\PostType\PostTypeFactory;
use CASS\Domain\Bundles\Post\Repository\PostRepository;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

class PostService implements EventEmitterAwareService
{
    use EventEmitterAwareTrait;

    const EVENT_CREATE = 'domain.post.create';
    const EVENT_UPDATE = 'domain.post.update';
    const EVENT_DELETE = 'domain.post.delete';
    const EVENT_DELETED = 'domain.post.deleted';

    /** @var PostRepository */
    private $postRepository;

    /** @var PostTypeFactory */
    private $postTypeFactory;
    
    /** @var ProfileService */
    private $profileService;
    
    /** @var CollectionService */
    private $collectionService;

    public function __construct(
        PostRepository $postRepository,
        PostTypeFactory $postTypeFactory,
        ProfileService $profileService,
        CollectionService $collectionService
    ) {
        $this->postRepository = $postRepository;
        $this->postTypeFactory = $postTypeFactory;
        $this->profileService = $profileService;
        $this->collectionService = $collectionService;
    }

    public function createPost(CreatePostParameters $createPostParameters): Post
    {
        $post = $this->createPostFromParameters($createPostParameters);

        $this->getEventEmitter()->emit(self::EVENT_CREATE, [$post, $createPostParameters]);

        return $post;
    }

    public function editPost(EditPostParameters $editPostParameters): Post
    {
        $post = $this->getPostById($editPostParameters->getPostId());
        $post->setContent($editPostParameters->getContent());

        $this->postRepository->savePost($post);
        $this->getEventEmitter()->emit(self::EVENT_UPDATE, [$post]);

        return $post;
    }

    public function deletePost(int $postId): Post
    {
        $post = $this->getPostById($postId);

        $this->getEventEmitter()->emit(self::EVENT_DELETE, [$post]);
        $this->postRepository->deletePost(
            $this->getPostById($postId)
        );
        $this->getEventEmitter()->emit(self::EVENT_DELETED, [$post]);

        return $post;
    }

    public function getPostById(int $postId): Post
    {
        return $this->postRepository->getPost($postId);
    }
    
    public function getPostsByIds(array $postIds): array 
    {
        return $this->postRepository->getPostsByIds($postIds);
    }

    public function loadPostsByIds(array $postIds)
    {
        $this->postRepository->getPostsByIds($postIds);
    }
    
    private function createPostFromParameters(CreatePostParameters $createPostParameters): Post
    {
        $postType = $this->postTypeFactory->createPostTypeByIntCode($createPostParameters->getPostTypeCode());
        $collection = $this->collectionService->getCollectionById($createPostParameters->getCollectionId());
        $profile = $this->profileService->getProfileById($createPostParameters->getProfileId());

        $post = new Post($postType, $profile, $collection, $createPostParameters->getContent());
        $post->setAttachmentIds($createPostParameters->getAttachmentIds());
        $post->setThemeIds($collection->getThemeIds());

        $this->postRepository->createPost($post);

        return $post;
    }
}