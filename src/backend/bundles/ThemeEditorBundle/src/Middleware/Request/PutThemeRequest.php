<?php
namespace ThemeEditor\Middleware\Request;

use Application\Tools\RequestParams\RequestParamsWithSchema;
use Application\Service\JSONSchema;
use Application\Tools\RequestParams\Param;
use Data\Repository\Theme\SaveThemeProperties;
use ThemeEditor\ThemeEditorBundle;

class PutThemeRequest extends RequestParamsWithSchema implements SaveThemeProperties
{
    /** @var string */
    private $title;

    /** @var int */
    private $parentId;

    /** @var int */
    private $position;

    protected function setup()
    {
        $data = $this->getData();

        $this->title = $this->createParam($data, 'title', true);
        $this->parentId = $this->createParam($data, 'parent_id');
        $this->position = $this->createParam($data, 'position');
    }

    protected function getValidatorSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ThemeEditorBundle::class, './definitions/request/PUTThemeRequest.yml');
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