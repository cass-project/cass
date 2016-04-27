<?php
namespace Post\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Post\Parameters\EditPostParameters;
use Post\PostBundle;

class EditPostRequest extends SchemaParams
{
    public function getParameters(): EditPostParameters {
        $data = $this->getData();

        return new EditPostParameters(
            (int) $data->post_id,
            (int) $data->collection_id,
            (string) $data->content
        );
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/EditPost.yml');
    }

}