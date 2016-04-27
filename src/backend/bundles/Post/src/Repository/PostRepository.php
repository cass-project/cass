<?php
namespace Post;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function createPost(int $profileId, int $collectionId, string $content) {
        throw new \Exception('Not implemented');
    }

    public function editPost(int $postId, int $collectionId, string $content) {
        throw new \Exception('Not implemented');
    }

    public function deletePost(int $postId) {
        throw new \Exception('Not implemented');
    }
}