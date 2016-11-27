<?php
namespace CASS\Domain\Bundles\Feed\Search\Stream\Streams;

use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Bundles\Collection\Formatter\CollectionFormatter;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\QueryStringCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\SeekCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\SortCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\ThemeIdCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\CriteriaManager;
use CASS\Domain\Bundles\Feed\Search\Stream\Stream;
use MongoDB\BSON\ObjectID;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

final class CollectionStream extends Stream
{
    /** @var CollectionService */
    private $collectionService;

    /** @var CollectionFormatter */
    private $collectionFormatter;

    public function __construct(
        CollectionService $collectionService,
        CollectionFormatter $collectionFormatter
    ) {
        $this->collectionService = $collectionService;
        $this->collectionFormatter = $collectionFormatter;
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

        return $this->cleanResults(array_map(function(BSONDocument $document) {
            try {
                return array_merge([
                    '_id' => (string) $document['_id']
                ], $this->collectionFormatter->formatOne($this->collectionService->getCollectionById((int) $document['id'])));
            }catch(CollectionNotFoundException $e) {
                return null;
            }
        }, $result));
    }
}