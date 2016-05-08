<?php
namespace Application\Post\Middleware\Request;

use Application\Common\Service\JSONSchema;
use Application\Common\Tools\RequestParams\SchemaParams;
use Application\Post\Parameters\CreatePostParameters;
use Application\Post\Parameters\LinkParameters;
use Application\Post\PostBundle;

class CreatePostRequest extends SchemaParams
{
    public function getParameters(): CreatePostParameters {
        $data = json_decode($this->getRequest()->getBody(), true);

        $links = array_map(function(array $params) {
            return new LinkParameters($params['url'], $params['metadata']);
        }, $data['links']);
        
        return new CreatePostParameters(
            (int) $data['profile_id'],
            (int) $data['collection_id'],
            (string) $data['content'],
            $links,
            $data['attachments']
        );
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(PostBundle::class, './definitions/request/CreatePost.yml');
    }
}