<?php
namespace Domain\IM\Query\Criteria;

use Domain\IM\Exception\Query\UnknownCriteriaException;
use Domain\IM\Query\Criteria\CursorCriteria\CursorCriteria;
use Domain\IM\Query\Criteria\SeekCriteria\SeekCriteria;
use Domain\IM\Query\Criteria\SortCriteria\SortCriteria;

final class CriteriaFactory
{
    public function createCriteriaFromStringCode(string $code, array $params): Criteria
    {
        switch($code) {
            default:
                throw new UnknownCriteriaException(sprintf('Unknown criteria `%s`', $code));

            case CursorCriteria::getCode():
                return CursorCriteria::createCriteriaFromParams($params);

            case SortCriteria::getCode():
                return SortCriteria::createCriteriaFromParams($params);

            case SeekCriteria::getCode():
                return SeekCriteria::createCriteriaFromParams($params);
        }
    }
}