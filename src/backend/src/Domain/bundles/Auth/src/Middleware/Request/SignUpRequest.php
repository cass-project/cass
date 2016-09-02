<?php
namespace CASS\Domain\Bundles\Auth\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Bundles\Auth\AuthBundle;
use CASS\Domain\Bundles\Auth\Parameters\SignUpParameters;

class SignUpRequest extends SchemaParams
{
    public function getParameters(): SignUpParameters
    {
        $data = $this->getData();

        return new SignUpParameters($data['email'], $data['password']);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(AuthBundle::class, './definitions/request/SignUpRequest.yml');
    }
}