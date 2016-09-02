<?php
namespace CASS\Domain\Bundles\Account\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Bundles\Account\AccountBundle;

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