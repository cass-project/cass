<?php
namespace Domain\Feed\Search\Stream;

use Domain\Feed\Search\Criteria\CriteriaManager;
use MongoDB\Collection;

final class CommunityStream extends Stream
{
    public function fetch(CriteriaManager $criteriaManager, Collection $collection): array
    {
        $filter = [];
        $options = [
            'limit' => self::DEFAULT_LIMIT,
        ];

        return $collection->find($filter, $options)->toArray();
    }
}