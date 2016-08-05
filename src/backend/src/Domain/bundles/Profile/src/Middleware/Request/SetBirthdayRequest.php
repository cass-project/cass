<?php
namespace Domain\Profile\Middleware\Request;

use Application\REST\Service\JSONSchema;
use Application\REST\Request\Params\SchemaParams;
use Domain\Profile\Parameters\SetBirthdayParameters;
use Domain\Profile\ProfileBundle;

class SetBirthdayRequest extends SchemaParams
{
    public function getParameters(): SetBirthdayParameters
    {
        return new SetBirthdayParameters(
            \DateTime::createFromFormat(\DateTime::RFC2822, $this->getData()['date'])
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/SetBirthdayRequest.yml');
    }
}