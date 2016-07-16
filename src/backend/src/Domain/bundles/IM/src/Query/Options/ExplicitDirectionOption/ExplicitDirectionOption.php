<?php
namespace Domain\IM\Exception\Query\Options\EnableDirectionOption;

use Domain\IM\Exception\Query\Options\Option;

final class ExplicitDirectionOption implements Option
{
    const OPTION_CODE = 'explicitDirection';

    /** @var boolean */
    private $isEnabled = false;

    public function __construct(bool $isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    public static function getCode(): string
    {
        return self::OPTION_CODE;
    }
    
    public static function createOptionFromParams(array $params): Option
    {
        return new self($params['enabled'] ?? false);
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }
}