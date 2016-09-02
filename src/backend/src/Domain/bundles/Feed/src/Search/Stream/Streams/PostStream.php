<?php
namespace CASS\Domain\Bundles\Feed\Search\Stream\Streams;

use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\ContentTypeCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\QueryStringCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\SeekCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\SortCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\CriteriaManager;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\ThemeIdCriteria;
use CASS\Domain\Bundles\Feed\Search\Stream\Stream;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Post\Exception\PostNotFoundException;
use CASS\Domain\Bundles\Post\Formatter\PostFormatter;
use CASS\Domain\Bundles\Post\Service\PostService;
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
        
        $criteriaManager->doWith(ThemeIdCriteria::class, function(ThemeIdCriteria $criteria) use (&$filter) {
            $filter[sprintf('theme_ids.%s', (string) $criteria->getThemeId())] = [
                '$exists' => true
            ];
        });
        
        $criteriaManager->doWith(ContentTypeCriteria::class, function(ContentTypeCriteria $criteria) use (&$filter) {
            $filter['content_type'] = $criteria->getContentType();
        });

        $criteriaManager->doWith(QueryStringCriteria::class, function(QueryStringCriteria $criteria) use (&$filter) {
            if($criteria->isAvailable()) {
                $filter['$text'] = [
                    '$search' => $criteria->getQuery()
                ];
            }
        });

        $result = $collection->find($filter, $options)->toArray();
        
        $this->postService->loadPostsByIds(array_map(function(BSONDocument $document) {
            return (int) $document['id'];
        }, $result));

        return $this->cleanResults(array_map(function(BSONDocument $document) {
            try {
                return array_merge([
                    '_id' => (string) $document['_id']
                ], $this->postFormatter->format(
                    $this->postService->getPostById((int) $document['id'])
                ));
            }catch(PostNotFoundException $e) {
                return null;
            }
        }, $result));
    }
}