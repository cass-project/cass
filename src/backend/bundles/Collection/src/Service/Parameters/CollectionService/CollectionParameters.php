<?php
namespace Collection\Service\Parameters\CollectionService;

use Common\Tools\RequestParams\Param;

interface CollectionParameters
{
    public function getTitle(): Param;
    public function getDescription(): Param;
    public function getParentId(): Param;
    public function getThemeId(): Param;
    public function getPosition(): Param;
}