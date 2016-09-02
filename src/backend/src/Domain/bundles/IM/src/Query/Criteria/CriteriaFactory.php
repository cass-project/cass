<?php
namespace CASS\Domain\Bundles\IM\Query\Criteria;

use CASS\Domain\Bundles\IM\Exception\Query\UnknownCriteriaException;
use CASS\Domain\Bundles\IM\Query\Criteria\CursorCriteria\CursorCriteria;
use CASS\Domain\Bundles\IM\Query\Criteria\SeekCriteria\SeekCriteria;
use CASS\Domain\Bundles\IM\Query\Criteria\SortCriteria\SortCriteria;

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