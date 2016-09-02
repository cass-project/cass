<?php
namespace CASS\Domain\Bundles\IM\Query\Criteria;

interface Criteria
{
    public static function getCode(): string;
    public static function createCriteriaFromParams(array $params): Criteria;
}