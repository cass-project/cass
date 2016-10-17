<?php
namespace CASS\Domain\Bundles\Post\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use CASS\Domain\Bundles\Post\Parameters\CreatePostParameters;
use CASS\Domain\Bundles\Post\PostBundle;

class CreatePostRequest extends SchemaParams
{
    public function getParameters(): CreatePostParameters
    {
        $data = $this->getData();

        return new CreatePostParameters(
            (int) $data['post_type'],
            (int) $data['profile_id'],
            (int) $data['collection_id'],
            $data['title'] ?? null,
            (string) $data['content'],
            $data['attachments']
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/CreatePost.yml');
    }
}