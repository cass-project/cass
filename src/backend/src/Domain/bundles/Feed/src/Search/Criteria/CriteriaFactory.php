<?php
namespace Domain\Feed\Search\Criteria;

use Domain\Feed\Exception\UnknownCriteriaException;
use Domain\Feed\Search\Criteria\Criteria\SeekCriteria;

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
        }
    }
}