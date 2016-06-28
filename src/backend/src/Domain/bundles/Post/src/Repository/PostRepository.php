<?php
namespace Domain\Post\Repository;

use Domain\Collection\Entity\Collection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Domain\Collection\Exception\CollectionNotFoundException;
use Domain\Feed\Feed\Criteria\SeekCriteria;
use Domain\Feed\Feed\CriteriaRequest;
use Domain\Post\Entity\Post;
use Domain\Post\Exception\PostNotFoundException;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;
use Domain\Profile\Exception\ProfileNotFoundException;

class PostRepository extends EntityRepository
{
    // TODO: Validation: Domain\Collection is owned by profile
    // TODO: Validation: Content
    public function createPost(int $profileId, int $collectionId, string $content): Post {
        $em = $this->getEntityManager();

        $authorProfile = $em->getRepository(Profile::class)->find($profileId);/** @var Profile $authorProfile */
        if(is_null($authorProfile)) throw new ProfileNotFoundException("Profile {$profileId} not found ");

        $collection = $em->getRepository(Collection::class)->find($collectionId);/** @var Collection $collection */
        if(is_null($collection)) throw new CollectionNotFoundException("Collection {$collectionId} not found");

        $post = new Post($authorProfile, $collection, $content);

        $em->persist($post);
        $em->flush($post);

        return $post;
    }

    public function editPost(int $postId, int $collectionId, string $content): Post {
        $em = $this->getEntityManager();

        $post = $this->getPost($postId);
        $collection = $em->getReference(Collection::class, $collectionId); /** @var Collection $collection */

        $post
            ->setCollection($collection)
            ->setContent($content);

        $em->flush($post);

        return $post;
    }

    public function deletePost(int $postId) {
        $post = $this->getPost($postId);

        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush($post);
    }

    public function getPost(int $postId): Post {
        $post = $this->find($postId);

        if($post === null) {
            throw new PostNotFoundException(sprintf('Domain\Post with id `%d` not found', $postId));
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

    public function getCommunityFeed(int $communityId, CriteriaRequest $criteriaRequest) {
        $qbCriteria = [
            'community' => $communityId
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
    
    public function getCommunityFeedTotal(int $communityId, CriteriaRequest $criteriaRequest): int {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder()
            ->select('count(p.id) as cnt')
            ->from(Post::class, 'p')
            ->where('p.community=:communityId')
            ->setParameter('communityId', $communityId)
        ;

        return (int) $qb->getQuery()->getResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}