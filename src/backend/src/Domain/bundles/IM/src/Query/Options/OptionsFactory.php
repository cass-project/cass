<?php
namespace CASS\Domain\IM\Query\Options;

use CASS\Domain\IM\Query\Options\MarkAsReadOption\MarkAsReadOption;
use CASS\Domain\IM\Exception\Query\UnknownOptionException;

final class OptionsFactory
{
    public function createFromStringCode(string $code, array $params): Option
    {
        switch($code) {
            default:
                throw new UnknownOptionException(sprintf('Unknown option `%s`', $code));

            case MarkAsReadOption::getCode():
                return MarkAsReadOption::createOptionFromParams($params);
        }
    }
}