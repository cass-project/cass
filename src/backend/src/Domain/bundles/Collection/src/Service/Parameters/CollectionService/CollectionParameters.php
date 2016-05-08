<?php
namespace Domain\Collection\Service\Parameters\CollectionService;

use Domain\Request\Params\Param;

interface CollectionParameters
{
    public function getTitle(): Param;
    public function getDescription(): Param;
    public function getParentId(): Param;
    public function getThemeId(): Param;
    public function getPosition(): Param;
}