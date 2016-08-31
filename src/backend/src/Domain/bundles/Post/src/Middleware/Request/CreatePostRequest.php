<?php
namespace Domain\Post\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use Domain\Post\Parameters\CreatePostParameters;
use Domain\Post\PostBundle;

class CreatePostRequest extends SchemaParams
{
    public function getParameters(): CreatePostParameters {

        $data = $this->getData();

        return new CreatePostParameters(
            (int) $data['post_type'],
            (int) $data['profile_id'],
            (int) $data['collection_id'],
            (string) $data['content'],
            $data['attachments']
        );
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/CreatePost.yml');
    }
}