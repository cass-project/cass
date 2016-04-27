<?php
namespace Post\Service;

use Auth\Service\CurrentAccountService;
use Common\Exception\NotImplementedException;
use Post\Parameters\CreatePostParameters;
use Post\Parameters\EditPostParameters;
use Post\PostRepository;

class PostService
{
    /** @var PostRepository */
    private $postRepository;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(PostRepository $postRepository, CurrentAccountService $currentAccountService) {
        $this->postRepository = $postRepository;
        $this->currentAccountService = $currentAccountService;
    }

    public function createPost(CreatePostParameters $createPostParameters) {
        throw new NotImplementedException;
    }

    public function editPost(EditPostParameters $editPostParameters) {
        throw new NotImplementedException;
    }

    public function deletePost(int $postId) {
        throw new NotImplementedException;
    }

    public function getPostById(int $postId) {
        throw new NotImplementedException;
    }
}