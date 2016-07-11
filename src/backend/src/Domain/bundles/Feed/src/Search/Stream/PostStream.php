<?php
namespace Domain\Feed\Search\Stream;

use Domain\Feed\Search\Criteria\Criteria\SeekCriteria;
use Domain\Feed\Search\Criteria\Criteria\SortCriteria;
use Domain\Feed\Search\Criteria\CriteriaManager;
use Domain\Post\Entity\Post;
use Domain\Post\Formatter\PostFormatter;
use Domain\Post\Service\PostService;
use MongoDB\BSON\ObjectID;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

final class PostStream extends Stream
{
    /** @var PostFormatter */
    private $postFormatter;

    /** @var PostService */
    private $postService;

    public function setPostFormatter(PostFormatter $postFormatter)
    {
        $this->postFormatter = $postFormatter;
    }

    public function setPostService(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function fetch(CriteriaManager $criteriaManager, Collection $collection): array
    {
        $filter = [];
        $options = [];

        $criteriaManager->doWith(SeekCriteria::class, function(SeekCriteria $criteria) use (&$options) {
            $options['limit'] = $criteria->getLimit();

            if($criteria->getLastId()) {
                $lastId = new ObjectID($criteria->getLastId());
                $filter['_id'] = [
                    '$gt' => $lastId
                ];
            }
        });

        $criteriaManager->doWith(SortCriteria::class, function(SortCriteria $criteria) use (&$options) {
            $options['sort'] = [];
            $options['sort'][$criteria->getField()] = strtolower($criteria->getOrder()) === 'asc' ? 1 : -1;
        });

        $cursor = $collection->find($filter, $options);
        
        $postEntities = $this->postService->getPostsByIds(array_map(function(BSONDocument $document) {
            return (int) $document['id'];
        }, $cursor->toArray()));

        return array_map(function(Post $post) {
            return $this->postFormatter->format($post);
        }, $postEntities);
    }
}