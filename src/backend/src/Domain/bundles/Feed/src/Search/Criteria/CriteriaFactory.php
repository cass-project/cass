<?php
namespace Domain\Feed\Search\Criteria;

use Domain\Feed\Exception\UnknownCriteriaException;
use Domain\Feed\Search\Criteria\Criteria\SeekCriteria;
use Domain\Feed\Search\Criteria\Criteria\SortCriteria;

final class CriteriaFactory
{
    public function createFromStringCode(string $code): Criteria
    {
        /**
         * Why is the thumbnail as Jaina drowning?﻿
         * https://www.youtube.com/watch?v=cGiQjZ1-9FI
         */
        switch($code) {
            default:
                throw new UnknownCriteriaException(sprintf('Unknown criteria with code `%s`', $code));

            case SeekCriteria::CODE_STRING:
                return new SeekCriteria();
            
            case SortCriteria::CODE_STRING:
                return new SortCriteria();
        }
    }
}