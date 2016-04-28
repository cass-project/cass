<?php
namespace Post\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Post\Parameters\EditPostParameters;
use Post\PostBundle;

class EditPostRequest extends SchemaParams
{
    public function getParameters(): EditPostParameters {
        $request = $this->getRequest();
        $data = $this->getData();

        return new EditPostParameters(
            (int) $request->getAttribute('postId'),
            (int) $data->collection_id,
            (string) $data->content
        );
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/EditPost.yml');
    }

}