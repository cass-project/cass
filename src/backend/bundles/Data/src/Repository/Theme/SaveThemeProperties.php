<?php
namespace Data\Repository\Theme;

use Common\Tools\RequestParams\Param;

interface SaveThemeProperties
{
    public function getTitle(): Param;
    public function getParentId(): Param;
    public function getPosition(): Param;
}