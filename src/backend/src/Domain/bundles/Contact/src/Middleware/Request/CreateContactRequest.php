<?php
namespace CASS\Domain\Contact\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Contact\ContactBundle;
use CASS\Domain\Contact\Parameters\CreateContactParameters;

final class CreateContactRequest extends SchemaParams
{
    public function getParameters(): CreateContactParameters
    {
        $data = $this->getData();

        return new CreateContactParameters((int) $data['profile_id']);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ContactBundle::class, './definitions/request/CreateContact.yml');
    }
}