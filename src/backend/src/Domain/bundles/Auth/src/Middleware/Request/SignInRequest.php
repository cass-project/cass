<?php
namespace Domain\Auth\Middleware\Request;

use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\JSONSchema;
use Domain\Auth\AuthBundle;
use Domain\Auth\Parameters\SignInParameters;

class SignInRequest extends SchemaParams
{
    public function getParameters(): SignInParameters
    {
        $data = $this->getData();

        return new SignInParameters($data->email, $data->password);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(AuthBundle::class, './definitions/request/SignInRequest.yml');
    }
}