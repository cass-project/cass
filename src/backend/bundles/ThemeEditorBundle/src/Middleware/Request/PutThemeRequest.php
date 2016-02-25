<?php
namespace ThemeEditor\Middleware\Request;

use Application\REST\RESTRequest;
use Application\Service\JSONSchema;
use Application\REST\Param;
use ThemeEditor\ThemeEditorBundle;

class PutThemeRequest extends RESTRequest
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

        $this->title = new Param($data, 'title', true);
        $this->parentId = new Param($data, 'parent_id');
        $this->position = new Param($data, 'position');
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