<?php
namespace CASS\Domain\Bundles\Feed\Search\Criteria\Criteria;

use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria;

final class QueryStringCriteria implements Criteria
{
    const MIN_QUERY_LENGTH = 3;
    const CODE_STRING = 'query_string';

    private $query;

    public function getCode(): string
    {
        return self::CODE_STRING;
    }

    public function unpack(array $criteria)
    {
        $this->query = $criteria['query'] ?? null;
    }

    public function isAvailable(): bool
    {
        return strlen($this->query) >= self::MIN_QUERY_LENGTH;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}