<?php
namespace Post\Repository;

use Collection\Entity\Collection;
use Doctrine\ORM\EntityRepository;
use Feed\Feed\Criteria\SeekCriteria;
use Feed\Feed\CriteriaRequest;
use Post\Entity\Post;
use Post\Exception\PostNotFoundException;
use Profile\Entity\Profile;

class PostRepository extends EntityRepository
{
    // TODO: Validation: Collection is owned by profile
    // TODO: Validation: Content
    public function createPost(int $profileId, int $collectionId, string $content): Post {
        $em = $this->getEntityManager();

        $authorProfile = $em->getReference(Profile::class, $profileId); /** @var Profile $authorProfile */
        $collection = $em->getReference(Collection::class, $collectionId); /** @var Collection $collection */

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
            throw new PostNotFoundException(sprintf('Post with id `%d` not found', $postId));
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
}