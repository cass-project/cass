<?php
namespace CASS\Domain\Feed\Search\Criteria\Criteria;

use CASS\Domain\Feed\Search\Criteria\Criteria;

final class ThemeIdCriteria implements Criteria
{
    const CODE_STRING = 'theme_id';

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

    public function getThemeId(): int
    {
        return $this->themeId;
    }
}