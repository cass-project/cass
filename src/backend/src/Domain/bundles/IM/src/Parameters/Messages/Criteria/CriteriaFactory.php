<?php
namespace Domain\IM\Parameters\Messages\Criteria;

use Domain\IM\Exception\Query\UnknownCriteriaException;
use Domain\IM\Parameters\Messages\Criteria\CursorCriteria\CursorCriteria;
use Domain\IM\Parameters\Messages\Criteria\SeekCriteria\SeekCriteria;
use Domain\IM\Parameters\Messages\Criteria\SortCriteria\SortCriteria;

final class CriteriaFactory
{
    public function createCriteriaFromStringCode(string $code): Criteria
    {
        switch($code) {
            default:
                throw new UnknownCriteriaException(sprintf('Unknown criteria `%s`', $code));

            case CursorCriteria::getCode():
                return new CursorCriteria();

            case SortCriteria::getCode():
                return new SortCriteria();

            case SeekCriteria::getCode():
                return new SeekCriteria();
        }
    }
}