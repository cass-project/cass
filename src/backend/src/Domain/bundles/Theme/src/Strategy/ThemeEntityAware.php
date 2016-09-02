<?php
namespace CASS\Domain\Bundles\Theme\Strategy;

use CASS\Domain\Bundles\Theme\Entity\Theme;

interface ThemeEntityAware
{
    public function getTheme(): Theme;
    public function hasTheme(): bool;
    public function setTheme(Theme $theme): Theme;
}