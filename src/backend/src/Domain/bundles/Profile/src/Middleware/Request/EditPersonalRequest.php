<?php
namespace Domain\Profile\Middleware\Request;

use Application\REST\Service\JSONSchema;
use Application\REST\Request\Params\SchemaParams;
use Domain\Profile\Middleware\Parameters\EditPersonalParameters;
use Domain\Profile\ProfileBundle;

class EditPersonalRequest extends SchemaParams
{
    public function getParameters(): EditPersonalParameters
    {
        $data = $this->getData();
        $parameters = new EditPersonalParameters(
            $data->method,
            $data->avatar ?? false,
            $data->first_name,
            $data->last_name,
            $data->middle_name,
            $data->nick_name
        );

        if(isset($data->gender) && is_string($data->gender)) {
            $parameters->specifyGender($data->gender);
        }

        return $parameters;
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/EditPersonalRequest.yml');
    }
}