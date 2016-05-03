<?php
namespace Post\Service;

use Auth\Service\CurrentAccountService;
use Post\Entity\Post;
use Post\Parameters\CreatePostParameters;
use Post\Parameters\EditPostParameters;
use Post\Repository\PostRepository;
use PostAttachment\Service\PostAttachmentService;

class PostService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var PostAttachmentService */
    private $postAttachmentService;

    /** @var PostRepository */
    private $postRepository;

    public function __construct(
        CurrentAccountService $currentAccountService,
        PostAttachmentService $postAttachmentService,
        PostRepository $postRepository
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->postAttachmentService = $postAttachmentService;
        $this->postRepository = $postRepository;
    }


    public function createPost(CreatePostParameters $createPostParameters): Post {
        $attachmentIds = $createPostParameters->getAttachmentIds();

        $post = $this->postRepository->createPost(
            $createPostParameters->getProfileId(),
            $createPostParameters->getCollectionId(),
            $createPostParameters->getContent()
        );
        
        foreach($createPostParameters->getLinks() as $link) {
            $attachmentIds[] = $this->postAttachmentService->createLinkAttachment($post, $link->getUrl(), $link->getMetadata())->getId();
        }

        $this->postAttachmentService->setAttachments($post, $attachmentIds);
        
        return $post;
    }

    public function editPost(EditPostParameters $editPostParameters): Post {
        return $this->postRepository->editPost(
            $editPostParameters->getPostId(),
            $editPostParameters->getCollectionId(),
            $editPostParameters->getContent()
        );
    }

    public function deletePost(int $postId) {
        $this->postRepository->deletePost($postId);
    }

    public function getPostById(int $postId): Post {
        return $this->postRepository->getPost($postId);
    }
}