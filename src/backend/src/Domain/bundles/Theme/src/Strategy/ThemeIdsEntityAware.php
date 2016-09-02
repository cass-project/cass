<?php
namespace CASS\Domain\Bundles\Theme\Strategy;

interface ThemeIdsEntityAware
{
    public function getThemeIds(): array;
    public function setThemeIds(array $themeIds): array;
}