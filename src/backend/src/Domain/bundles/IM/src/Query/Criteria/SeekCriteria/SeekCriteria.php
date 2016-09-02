<?php
namespace CASS\Domain\IM\Query\Criteria\SeekCriteria;

use CASS\Domain\IM\Exception\Query\InvalidCriteriaParamsException;
use CASS\Domain\IM\Query\Criteria\Criteria;

final class SeekCriteria implements Criteria
{
    const CRITERIA_CODE = 'seek';
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 100;
    const MAX_LIMIT = 1000;

    /** @var int */
    private $offset = self::DEFAULT_OFFSET;

    /** @var int */
    private $limit = self::DEFAULT_LIMIT;

    public function __construct(int $offset, int $limit)
    {
        if($limit < 0 || $limit > self::MAX_LIMIT) {
            throw new InvalidCriteriaParamsException(sprintf('Invalid limit `%s`. Limit should be in range (%d, %d)', $limit, 0, self::MAX_LIMIT));
        }

        if($offset < 0) {
            throw new InvalidCriteriaParamsException(sprintf('Invalid offset `%s`. Offset should be more than zero', $offset));
        }

        $this->offset = $offset;
        $this->limit = $limit;
    }

    public static function getCode(): string
    {
        return self::CRITERIA_CODE;
    }

    public static function createCriteriaFromParams(array $params): Criteria
    {
        $offset = (int) ($params['offset'] ?? self::DEFAULT_OFFSET);
        $limit = (int) ($params['limit'] ?? self::DEFAULT_LIMIT);

        return new self($offset, $limit);
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}