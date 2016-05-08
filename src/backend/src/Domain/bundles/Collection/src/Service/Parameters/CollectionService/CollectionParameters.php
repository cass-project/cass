<?php
namespace Domain\Collection\Service\Parameters\CollectionService;

use Application\REST\Request\Params\Param;

interface CollectionParameters
{
    public function getTitle(): Param;
    public function getDescription(): Param;
    public function getParentId(): Param;
    public function getThemeId(): Param;
    public function getPosition(): Param;
}