<?php
namespace Domain\Feed\Feed\Criteria;

use Domain\Feed\Exception\Criteria\SeekInvalidOffsetException;
use Domain\Feed\Exception\Criteria\SeekLimitBoundException;
use Domain\Feed\Feed\Criteria;

final class SeekCriteria implements Criteria
{
    const MIN_LIMIT = 1;
    const MAX_LIMIT = 100;

    /** @var int */
    private $limit;

    /** @var int */
    private $offset;

    public static function isAvailable(array $request): bool {
        return isset($request['seek'])
            && isset($request['seek']['offset'])
            && is_numeric($request['seek']['offset'])
            && isset($request['seek']['limit'])
            && is_numeric($request['seek']['limit'])
        ;
    }

    public function __construct(array $request) {
        $seek = $request['seek'];

        $this->setLimit($seek['limit']);
        $this->setOffset($seek['offset']);
    }

    private function setLimit(int $limit) {
        if(($limit < self::MIN_LIMIT) || ($limit > self::MAX_LIMIT)) {
            throw new SeekLimitBoundException(sprintf('Limit should be more than %d and less than %d', self::MIN_LIMIT, self::MAX_LIMIT));
        }

        $this->limit = $limit;
    }

    private function setOffset(int $offset) {
        if($offset < 0) {
            throw new SeekInvalidOffsetException('Offset should be more than 0');
        }

        $this->offset = $offset;
    }

    public function getLimit(): int {
        return $this->limit;
    }

    public function getMinLimit(): int {
        return self::MIN_LIMIT;
    }

    public function getMaxLimit(): int {
        return self::MAX_LIMIT;
    }

    public function getOffset(): int {
        return $this->offset;
    }
}