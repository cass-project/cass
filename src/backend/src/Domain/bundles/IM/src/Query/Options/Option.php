<?php
namespace CASS\Domain\Bundles\IM\Query\Options;


interface Option
{
    public static function getCode(): string;
    public static function createOptionFromParams(array $params): Option;
}