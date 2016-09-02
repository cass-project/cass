<?php
namespace CASS\Domain\Bundles\Theme\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use CASS\Domain\Bundles\Theme\Parameters\CreateThemeParameters;
use CASS\Domain\Bundles\Theme\ThemeBundle;

class CreateThemeRequest extends SchemaParams
{
    public function getParameters(): CreateThemeParameters {
        $data = $this->getData();

        $parentId = $data['parent_id'] ?? null;

        return new CreateThemeParameters(
            $data['title'],
            $data['description'],
            $data['preview'] ?? Theme::DEFAULT_PREVIEW,
            $parentId,
            $data['force_id'] ?? null,
            $data['url'] ?? null
        );
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(ThemeBundle::class, './definitions/request/CreateThemeRequest.yml');
    }
}