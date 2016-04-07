<?php
namespace Data\Repository\Theme;

use Application\Tools\RequestParams\Param;

interface SaveThemeProperties
{
    public function getTitle(): Param;
    public function getParentId(): Param;
    public function getPosition(): Param;
}