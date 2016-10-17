<?php
namespace CASS\Domain\Bundles\Post\Repository;

use CASS\Util\Seek;
use Doctrine\ORM\EntityRepository;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Post\Exception\PostNotFoundException;

class PostRepository extends EntityRepository
{
    public function createPost(Post $post): int
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush($post);

        return $post->getId();
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

    public function listPost(Seek $criteria): array
    {
        $qb = $this->createQueryBuilder('p');
        $qb->setFirstResult($criteria->getOffset());
        $qb->setMaxResults($criteria->getLimit());

        /** @var Post[] $result */
        $result = $qb->getQuery()->execute();

        return $result;
    }

    public function getPost(int $postId): Post
    {
        $post = $this->find($postId);

        if($post instanceof Post) {
            return $post;
        }else{
            throw new PostNotFoundException(sprintf('Post (ID: `%d`) not found', $postId));
        }
    }

    public function getPostsByIds(array $ids): array
    {
        return $this->findBy([
            'id' => $ids,
        ]);
    }
}