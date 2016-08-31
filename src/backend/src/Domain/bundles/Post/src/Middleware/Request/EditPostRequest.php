<?php
namespace Domain\Post\Middleware\Request;

use CASS\Application\REST\Service\JSONSchema;
use CASS\Application\REST\Request\Params\SchemaParams;
use Domain\Post\Parameters\EditPostParameters;
use Domain\Post\PostBundle;

class EditPostRequest extends SchemaParams
{
    public function getParameters(): EditPostParameters {
        $request = $this->getRequest();
        $data = $this->getData();

        return new EditPostParameters(
            (int) $request->getAttribute('postId'),
            (string) $data['content']
        );
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/EditPost.yml');
    }

}