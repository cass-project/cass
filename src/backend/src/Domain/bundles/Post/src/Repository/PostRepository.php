<?php
namespace Domain\Post\Repository;

use Domain\Collection\Collection\CollectionItem;
use Domain\Collection\Entity\Collection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Domain\Collection\Exception\CollectionNotFoundException;
use Domain\Community\Entity\Community;
use Domain\Community\Exception\CommunityNotFoundException;
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

    public function getCommunityFeed(int $communityId, CriteriaRequest $criteriaRequest) {

        list($limit, $offset) = $criteriaRequest->doWith(SeekCriteria::class, function(SeekCriteria $seekCriteria) {
            return [$seekCriteria->getLimit(), $seekCriteria->getOffset()];
        });

        /** @var Community $community */
        $community = $this->getEntityManager()->getRepository(Community::class)->find($communityId);
        if(is_null($community)) throw new CommunityNotFoundException(sprintf("Community: %s not found",$communityId));

        $collectionIds = [];
        foreach($community->getCollections()->getItems() as $collection){
            /** @var CollectionItem $collection */
            $collectionIds[] = $collection->getCollectionId();
        }
        $qbCriteria = [
            'collection' => $collectionIds
        ];

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
        return count($this->getCommunityFeed($communityId,$criteriaRequest)) ;
    }
}