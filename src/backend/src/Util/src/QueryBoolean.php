<?php
namespace CASS\Util;

final class QueryBoolean
{
    public static function extract(string $query)
    {
        return $query === '1' || $query === 1 || $query === 'true' || $query === 'y' || $query === 'yes';
    }
}