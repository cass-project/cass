<?php
namespace Domain\Collection\Service\Parameters\CollectionService;

use Application\REST\Request\Params\Param;

class CollectionCreateParameters implements CollectionParameters
{
    /** @var Param */
    private $title;

    /** @var Param */
    private $description;

    /** @var Param */
    private $themeId;

    /** @var Param */
    private $parentId;

    /** @var Param */
    private $position;

    public function __construct(Param $title, Param $description, Param $themeId, Param $parentId, Param $position)
    {
        $this->title = $title;
        $this->description = $description;
        $this->themeId  = $themeId;
        $this->parentId = $parentId;
        $this->position = $position;
    }

    public function getTitle(): Param
    {
        return $this->title;
    }

    public function getDescription() : Param
    {
        return $this->description;
    }

    public function getThemeId() : Param
    {
        return $this->themeId;
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