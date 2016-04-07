<?php
namespace Data\Repository\Theme\Parameters;

use Application\Tools\RequestParams\Param;
use Data\Repository\Theme\SaveThemeProperties;

class CreateThemeParameters implements SaveThemeProperties
{
    /** @var Param */
    private $title;

    /** @var Param */
    private $parentId;

    /** @var Param */
    private $position;

    public function __construct(Param $title, Param $parentId, Param $position)
    {
        $this->title = $title;
        $this->parentId = $parentId;
        $this->position = $position;
    }

    public function getTitle(): Param
    {
        return $this->title;
    }

    public function getParentId(): Param
    {
        return $this->parentId;
    }

    public function getPosition(): Param
    {
        return $this->position;
    }
}