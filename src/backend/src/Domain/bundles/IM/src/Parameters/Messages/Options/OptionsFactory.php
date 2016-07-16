<?php
namespace Domain\IM\Exception\Query\Options;

use Domain\IM\Exception\Query\Options\EnableDirectionOption\ExplicitDirectionOption;
use Domain\IM\Exception\Query\Options\MarkAsReadOption\MarkAsReadOption;
use Domain\IM\Exception\Query\UnknownOptionException;

final class OptionsFactory
{
    public function createFromStringCode(string $code): Option
    {
        switch($code) {
            default:
                throw new UnknownOptionException(sprintf('Unknown option `%s`', $code));

            case MarkAsReadOption::getCode():
                return new MarkAsReadOption();

            case ExplicitDirectionOption::getCode():
                return new ExplicitDirectionOption();
        }
    }
}