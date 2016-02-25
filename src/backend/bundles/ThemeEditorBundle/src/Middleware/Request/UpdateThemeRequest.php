<?php
namespace ThemeEditor\Middleware\Request;

use Application\Tools\RequestParams\Param;
use Application\Tools\RequestParams\RequestParamsWithSchema;
use Application\Service\JSONSchema;
use Data\Repository\Theme\SaveThemeProperties;
use ThemeEditor\ThemeEditorBundle;

class UpdateThemeRequest extends RequestParamsWithSchema implements SaveThemeProperties
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var int */
    private $parentId;

    /** @var int */
    private $position;

    protected function setup()
    {
        $data = $this->getData();
        $request = $this->getRequest();

        $this->id = (int) $request->getAttribute('themeId');
        $this->title = $this->createParam($data, 'title', true);
        $this->parentId = $this->createParam($data, 'parent_id');
        $this->position = $this->createParam($data, 'position');
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

    protected function getValidatorSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ThemeEditorBundle::class, './definitions/request/UpdateThemeRequest.yml');
    }
}