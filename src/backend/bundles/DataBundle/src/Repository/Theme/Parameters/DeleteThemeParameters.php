<?php
namespace Data\Repository\Theme\Parameters;

class DeleteThemeParameters
{
    /** @var int */
    private $themeId;

    public function __construct(int $themeId)
    {
        $this->themeId = $themeId;
    }

    public function getThemeId(): int
    {
        return $this->themeId;
    }
}