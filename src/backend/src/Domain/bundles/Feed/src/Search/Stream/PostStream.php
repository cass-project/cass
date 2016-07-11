<?php
namespace Domain\Feed\Search\Stream;

use Domain\Feed\Search\Criteria\Criteria\SeekCriteria;
use Domain\Feed\Search\Criteria\Criteria\SortCriteria;
use Domain\Feed\Search\Criteria\CriteriaManager;
use MongoDB\BSON\ObjectID;
use MongoDB\Collection;

final class PostStream extends Stream
{
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

        return $cursor->toArray();
    }
}