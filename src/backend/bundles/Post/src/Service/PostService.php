<?php
namespace Post\Service;

use Auth\Service\CurrentAccountService;
use Post\Entity\Post;
use Post\Parameters\CreatePostParameters;
use Post\Parameters\EditPostParameters;
use Post\Repository\PostRepository;

class PostService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var PostRepository */
    private $postRepository;

    public function __construct(CurrentAccountService $currentAccountService, PostRepository $postRepository) {
        $this->currentAccountService = $currentAccountService;
        $this->postRepository = $postRepository;
    }

    public function createPost(CreatePostParameters $createPostParameters): Post {
        return $this->postRepository->createPost(
            $createPostParameters->getProfileId(),
            $createPostParameters->getCollectionId(),
            $createPostParameters->getContent()
        );
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