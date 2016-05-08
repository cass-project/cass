<?php
namespace Domain\Collection\Service\Parameters\CollectionService;

use Application\Common\Tools\RequestParams\Param;

interface CollectionParameters
{
    public function getTitle(): Param;
    public function getDescription(): Param;
    public function getParentId(): Param;
    public function getThemeId(): Param;
    public function getPosition(): Param;
}