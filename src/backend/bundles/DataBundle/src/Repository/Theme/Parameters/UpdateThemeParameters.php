<?php
namespace Data\Repository\Theme\Parameters;

use Application\Tools\RequestParams\Param;
use Data\Repository\Theme\SaveThemeProperties;

class UpdateThemeParameters implements SaveThemeProperties
{
    /** @var int */
    private $id;

    /** @var Param */
    private $title;

    /** @var Param */
    private $parentId;

    /** @var Param */
    private $position;

    public function __construct(int $id, Param $title, Param $parentId, Param $position)
    {
        $this->id = $id;
        $this->title = $title;
        $this->parentId = $parentId;
        $this->position = $position;
    }

    public function getId(): int
    {
        return $this->id;
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