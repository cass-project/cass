<?php
namespace Domain\Post\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Post\Entity\Post;
use Domain\Post\Exception\PostNotFoundException;
use Domain\Profile\Entity\Profile\Greetings;

class PostRepository extends EntityRepository
{
    public function createPost(Post $post)
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush($post);
    }

    public function savePost(Post $post)
    {
        $this->getEntityManager()->flush($post);
    }

    public function deletePost(Post $post)
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush($post);
    }

    public function getPost(int $postId): Post {
        $post = $this->find($postId);

        if($post === null) {
            throw new PostNotFoundException(sprintf('Post (ID: `%d`) not found', $postId));
        }

        return $post;
    }

    public function getPostsByIds(array $ids): array {
        return $this->findBy([
            'id' => $ids
        ]);
    }
}