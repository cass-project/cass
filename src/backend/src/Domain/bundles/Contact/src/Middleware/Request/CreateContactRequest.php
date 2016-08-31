<?php
namespace Domain\Contact\Middleware\Request;

use CASS\Application\REST\Request\Params\SchemaParams;
use CASS\Application\REST\Service\JSONSchema;
use Domain\Contact\ContactBundle;
use Domain\Contact\Parameters\CreateContactParameters;

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