<?php
namespace Domain\IM\Parameters\Messages\Criteria\SeekCriteria;

use Domain\IM\Exception\Query\InvalidCriteriaParamsException;
use Domain\IM\Parameters\Messages\Criteria\Criteria;

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

    public static function getCode(): string
    {
        return self::CRITERIA_CODE;
    }

    public function unpack(array $params)
    {
        $this->offset = (int) ($params['offset'] ?? self::DEFAULT_OFFSET);
        $this->limit = (int) ($params['limit'] ?? self::DEFAULT_LIMIT);

        if($this->limit < 0 || $this->limit > self::MAX_LIMIT) {
            throw new InvalidCriteriaParamsException(sprintf('Invalid limit `%s`. Limit should be in range (%d, %d)', $this->limit, 0, self::MAX_LIMIT));
        }

        if($this->offset < 0) {
            throw new InvalidCriteriaParamsException(sprintf('Invalid offset `%s`. Offset should be more than zero', $this->offset));
        }
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