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
        $order = 1;
        $filter = [];
        $options = [
            'limit' => self::DEFAULT_LIMIT,
        ];

        $criteriaManager->doWith(SortCriteria::class, function(SortCriteria $criteria) use (&$options, &$order) {
            $order = strtolower($criteria->getOrder()) === 'asc' ? 1 : -1;

            $options['sort'] = [];
            $options['sort'][$criteria->getField()] = $order;
        });

        $criteriaManager->doWith(SeekCriteria::class, function(SeekCriteria $criteria) use (&$options, &$filter, $order) {
            $options['limit'] = $criteria->getLimit();
            $options['skip'] = 0;

            if($criteria->getLastId()) {
                $lastId = new ObjectID($criteria->getLastId());

                if($order === 1) {
                    $filter['_id'] = [
                        '$gt' => $lastId
                    ];
                }else{
                    $filter['_id'] = [
                        '$lt' => $lastId
                    ];
                }
            }
        });

        $result = $collection->find($filter, $options)->toArray();
        
        $this->postService->getPostsByIds(array_map(function(BSONDocument $document) {
            return (int) $document['id'];
        }, $result));

        return  array_map(function(BSONDocument $document) {
            return $this->postFormatter->format(
                $this->postService->getPostById((int) $document['id'])
            );
        }, $result);
    }
}