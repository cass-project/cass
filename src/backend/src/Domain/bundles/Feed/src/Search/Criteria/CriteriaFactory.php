<?php
namespace CASS\Domain\Bundles\Feed\Search\Criteria;

use CASS\Domain\Bundles\Feed\Exception\UnknownCriteriaException;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\ContentTypeCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\QueryStringCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\SeekCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\SortCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\ThemeIdCriteria;

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

            case ThemeIdCriteria::CODE_STRING:
                return new ThemeIdCriteria();

            case ContentTypeCriteria::CRITERIA_CODE:
                return new ContentTypeCriteria();

            case QueryStringCriteria::CODE_STRING:
                return new QueryStringCriteria();
        }
    }
}