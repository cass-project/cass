<?php
namespace Domain\Feed\Search\Criteria;

final class ThemeIdCriteria
{
    const CODE_STRING = 'theme-id';

    /** @var int */
    private $themeId;

    public function getCode(): string
    {
        return self::CODE_STRING;
    }

    public function unpack(array $criteria)
    {
        $this->themeId = $criteria['id'] ?? null;
    }
}