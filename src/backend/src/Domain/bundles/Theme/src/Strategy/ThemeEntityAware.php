<?php
namespace Domain\Theme\Strategy;

use Domain\Theme\Entity\Theme;

interface ThemeEntityAware
{
    public function getTheme(): Theme;
    public function hasTheme(): bool;
    public function setTheme(Theme $theme): Theme;
}