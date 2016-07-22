<?php
namespace Domain\Feed\Search\Stream\Streams;

use Domain\Collection\Service\CollectionService;
use Domain\Feed\Search\Criteria\Criteria\QueryStringCriteria;
use Domain\Feed\Search\Criteria\Criteria\SeekCriteria;
use Domain\Feed\Search\Criteria\Criteria\SortCriteria;
use Domain\Feed\Search\Criteria\Criteria\ThemeIdCriteria;
use Domain\Feed\Search\Criteria\CriteriaManager;
use Domain\Feed\Search\Stream\Stream;
use MongoDB\BSON\ObjectID;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

final class CollectionStream extends Stream
{
    /** @var CollectionService */
    private $collectionService;

    public function setCollectionService($collectionService)
    {
        $this->collectionService = $collectionService;
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

        $criteriaManager->doWith(QueryStringCriteria::class, function(QueryStringCriteria $criteria) use (&$filter) {
            if($criteria->isAvailable()) {
                $filter['$text'] = [
                    '$search' => $criteria->getQuery()
                ];
            }
        });
        
        $result = $collection->find($filter, $options)->toArray();

        $this->collectionService->loadCollectionsByIds(array_map(function(BSONDocument $document) {
            return (int) $document['id'];
        }, $result));

        return array_map(function(BSONDocument $document) {
            return $this->collectionService->getCollectionById((int) $document['id'])->toJSON();
        }, $result);
    }
}