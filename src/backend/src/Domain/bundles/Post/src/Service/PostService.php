<?php
namespace Domain\Post\Service;

use Application\Service\EventEmitterAware\EventEmitterAwareService;
use Application\Service\EventEmitterAware\EventEmitterAwareTrait;
use Domain\Collection\Service\CollectionService;
use Domain\Post\Entity\Post;
use Domain\Post\Parameters\CreatePostParameters;
use Domain\Post\Parameters\EditPostParameters;
use Domain\Post\Parameters\LinkParameters;
use Domain\Post\PostType\PostTypeFactory;
use Domain\Post\Repository\PostRepository;
use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Entity\PostAttachment\LinkAttachmentType;
use Domain\PostAttachment\Service\PostAttachmentService;
use Domain\Profile\Service\ProfileService;

class PostService implements EventEmitterAwareService
{
    use EventEmitterAwareTrait;

    const EVENT_CREATE = 'domain.post.create';
    const EVENT_UPDATE = 'domain.post.update';
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
        $post = $this->createPostFromParameters($createPostParameters);
        $this->createPostAttachmentLinksFromArray($post, $createPostParameters->getLinks());

        $this->postRepository->savePost($post);

        $this->getEventEmitter()->emit(self::EVENT_CREATE, [$post]);

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

    public function deletePost(int $postId)
    {
        $this->postRepository->deletePost(
            $this->getPostById($postId)
        );
    }

    public function getPostById(int $postId): Post
    {
        return $this->postRepository->getPost($postId);
    }
    
    private function createPostFromParameters(CreatePostParameters $createPostParameters): Post
    {
        $postType = $this->postTypeFactory->createPostTypeByIntCode($createPostParameters->getPostTypeCode());
        $collection = $this->collectionService->getCollectionById($createPostParameters->getCollectionId());
        $profile = $this->profileService->getProfileById($createPostParameters->getProfileId());

        $post = new Post($postType, $profile, $collection, $createPostParameters->getContent());

        $this->postRepository->createPost($post);

        array_map(function(int $postAttachmentId) use ($post) {
            $this->postAttachmentService->addAttachment(
                $post,
                $this->postAttachmentService->getPostAttachmentById($postAttachmentId)
            );
        }, $createPostParameters->getAttachmentIds());

        return $post;
    }

    private function createPostAttachmentLinksFromArray(Post $post, array $links): array
    {
        /** @var LinkAttachmentType[] $result */
        $result = array_map(function(LinkParameters $linkParameters) use ($post) {
            $this->postAttachmentService->addAttachment(
                $post,
                $this->postAttachmentService->createLinkAttachment($post, $linkParameters->getUrl(), $linkParameters->getMetadata())
            );
        }, $links);

        return $result;
    }
}