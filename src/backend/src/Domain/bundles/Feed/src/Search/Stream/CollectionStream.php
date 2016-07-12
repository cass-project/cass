<?php
namespace Domain\Feed\Search\Stream;

use Application\Exception\NotImplementedException;
use Domain\Feed\Search\Criteria\CriteriaManager;
use Domain\Feed\Service\Entity;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

final class CollectionStream extends Stream
{
    public function fetch(CriteriaManager $criteriaManager, Collection $collection): array
    {
        $filter = [];
        $options = [];

        return $collection->find($filter, $options)->toArray();
    }
}