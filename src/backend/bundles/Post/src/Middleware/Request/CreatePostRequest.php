<?php
namespace Post\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\SchemaParams;
use Post\Parameters\CreatePostParameters;
use Post\PostBundle;

class CreatePostRequest extends SchemaParams
{
    public function getParameters(): CreatePostParameters {
        $data = $this->getData();

        return new CreatePostParameters(
            (int) $data->profile_id,
            (int) $data->collection_id,
            (string) $data->content
        );
    }

    protected function getSchema(): JSONSchema {
        
    }
}