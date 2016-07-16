<?php
namespace Domain\IM\Query\Options;

use Domain\IM\Exception\Query\Options\MarkAsReadOption\MarkAsReadOption;
use Domain\IM\Exception\Query\Options\Option;
use Domain\IM\Exception\Query\UnknownOptionException;

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