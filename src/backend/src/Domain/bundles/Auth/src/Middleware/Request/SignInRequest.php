<?php
namespace CASS\Domain\Bundles\Auth\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Bundles\Auth\AuthBundle;
use CASS\Domain\Bundles\Auth\Parameters\SignInParameters;

class SignInRequest extends SchemaParams
{
    public function getParameters(): SignInParameters
    {
        $data = $this->getData();

        return new SignInParameters($data['email'], $data['password']);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(AuthBundle::class, './definitions/request/SignInRequest.yml');
    }
}