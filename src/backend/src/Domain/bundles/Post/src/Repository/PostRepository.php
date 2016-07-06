<?php
namespace Domain\Post\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Domain\Feed\Feed\Criteria\SeekCriteria;
use Domain\Feed\Feed\CriteriaRequest;
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

    public function getFeed(int $collectionId, CriteriaRequest $criteriaRequest) {
        $qbCriteria = [
            'collection' => $collectionId
        ];
        
        list($limit, $offset) = $criteriaRequest->doWith(SeekCriteria::class, function(SeekCriteria $seekCriteria) {
            return [$seekCriteria->getLimit(), $seekCriteria->getOffset()];
        });

        return $this->findBy($qbCriteria, ['id' => 'desc'], $limit, $offset);
    }

    public function getFeedTotal(int $collectionId, CriteriaRequest $criteriaRequest): int {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder()
            ->select('count(p.id) as cnt')
            ->from(Post::class, 'p')
            ->where('p.collection=:collectionId')
            ->setParameter('collectionId', $collectionId)
        ;

        return (int) $qb->getQuery()->getResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}