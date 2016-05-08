<?php
namespace Application\Post\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
use Application\Post\Parameters\EditPostParameters;
use Application\Post\PostBundle;

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