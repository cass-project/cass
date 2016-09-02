<?php
namespace CASS\Domain\Bundles\Post\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use CASS\Domain\Bundles\Post\Parameters\EditPostParameters;
use CASS\Domain\Bundles\Post\PostBundle;

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