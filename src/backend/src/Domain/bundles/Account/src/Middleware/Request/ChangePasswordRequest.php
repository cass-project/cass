<?php
namespace Domain\Account\Middleware\Request;

use CASS\Application\REST\Request\Params\SchemaParams;
use CASS\Application\REST\Service\JSONSchema;
use Domain\Account\AccountBundle;

class ChangePasswordRequest extends SchemaParams
{
    public function getParameters()
    {
        return $this->getData();
    }

    protected function getSchema(): JSONSchema
    {
        return SchemaParams::getSchemaService()->getSchema(AccountBundle::class, './definitions/request/ChangePasswordRequest.yml');
    }
}