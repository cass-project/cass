<?php
namespace Domain\IM\Exception\Query\Options\EnableDirectionOption;

use Domain\IM\Exception\Query\Options\Option;

final class ExplicitDirectionOption implements Option
{
    const OPTION_CODE = 'explicitDirection';

    /** @var boolean */
    private $isEnabled = false;

    public static function getCode(): string
    {
        return self::OPTION_CODE;
    }

    public function unpack(array $params)
    {
        $this->isEnabled = $params['enabled'] ?? false;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }
}