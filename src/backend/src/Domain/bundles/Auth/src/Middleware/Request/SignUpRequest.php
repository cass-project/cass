<?php
namespace Domain\Auth\Middleware\Request;

use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\JSONSchema;
use Domain\Auth\AuthBundle;
use Domain\Auth\Parameters\SignUpParameters;

class SignUpRequest extends SchemaParams
{
    public function getParameters(): SignUpParameters
    {
        $data = $this->getData();

        return new SignUpParameters($data->email, $data->password, $data->repeat);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(AuthBundle::class, './definitions/request/SignUpRequest.yml');
    }
}