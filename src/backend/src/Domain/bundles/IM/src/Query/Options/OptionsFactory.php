<?php
namespace CASS\Domain\Bundles\IM\Query\Options;

use CASS\Domain\Bundles\IM\Query\Options\MarkAsReadOption\MarkAsReadOption;
use CASS\Domain\Bundles\IM\Exception\Query\UnknownOptionException;

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