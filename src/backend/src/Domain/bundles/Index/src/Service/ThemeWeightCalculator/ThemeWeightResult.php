<?php
namespace CASS\Domain\Index\Service\ThemeWeightCalculator;

final class ThemeWeightResult
{
    /** @var int */
    private $themeId;

    /** @var int */
    private $weight;

    public function __construct(int $themeId, int $weight)
    {
        $this->themeId = $themeId;
        $this->weight = $weight;
    }

    public function getThemeId(): int
    {
        return $this->themeId;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }
}