<?php
namespace Data\Repository\Theme\Parameters;

class MoveThemeParameters
{
    /** @var int */
    private $themeId;

    /** @var int */
    private $moveToParentThemeId;

    /** @var int */
    private $moveToPosition;

    public function __construct(int $themeId, int $moveToParentThemeId, int $moveToPosition)
    {
        $this->themeId = $themeId;
        $this->moveToParentThemeId = $moveToParentThemeId;
        $this->moveToPosition = $moveToPosition;
    }

    public function getThemeId(): int
    {
        return $this->themeId;
    }

    public function getMoveToParentThemeId(): int
    {
        return $this->moveToParentThemeId;
    }

    public function getMoveToPosition(): int
    {
        return $this->moveToPosition;
    }
}