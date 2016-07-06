<?php
namespace Domain\Post\Service;

use Application\Exception\NotImplementedException;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Post\Entity\Post;
use Domain\Post\Parameters\CreatePostParameters;
use Domain\Post\Parameters\EditPostParameters;
use Domain\Post\Repository\PostRepository;
use Domain\PostAttachment\Service\PostAttachmentService;

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

    public function createPost(CreatePostParameters $createPostParameters): Post
    {
        throw new NotImplementedException;
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