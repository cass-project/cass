<?php
namespace CASS\Domain\Profile\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use CASS\Domain\Profile\Parameters\EditPersonalParameters;
use CASS\Domain\Profile\ProfileBundle;

class EditPersonalRequest extends SchemaParams
{
    public function getParameters(): EditPersonalParameters
    {
        $data = $this->getData();
        $parameters = new EditPersonalParameters(
            $data['method'],
            $data['avatar'] ?? false,
            $data['first_name'],
            $data['last_name'],
            $data['middle_name'],
            $data['nick_name']
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