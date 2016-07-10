<?php
namespace Domain\Feed\Search\Criteria\Criteria;

use Domain\Feed\Search\Criteria\Criteria;

final class SeekCriteria implements Criteria
{
    const CODE_STRING = 'seek';

    private $cursor;
    private $limit;

    public function getCode(): string
    {
        return self::CODE_STRING;
    }

    public function unpack(array $criteria)
    {
        $this->limit = $criteria['limit'] ?? null;
    }
}