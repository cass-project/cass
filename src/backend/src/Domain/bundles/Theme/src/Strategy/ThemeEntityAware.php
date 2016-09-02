<?php
namespace CASS\Domain\Theme\Strategy;

use CASS\Domain\Theme\Entity\Theme;

interface ThemeEntityAware
{
    public function getTheme(): Theme;
    public function hasTheme(): bool;
    public function setTheme(Theme $theme): Theme;
}