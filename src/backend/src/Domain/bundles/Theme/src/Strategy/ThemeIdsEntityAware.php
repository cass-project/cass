<?php
namespace Domain\Theme\Strategy;

interface ThemeIdsEntityAware
{
    public function getThemeIds(): array;
    public function setThemeIds(array $themeIds): array;
}