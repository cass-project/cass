<?php
namespace CASS\Domain\Feedback\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Feedback\FeedbackBundle;
use CASS\Domain\Feedback\Middleware\Parameters\CreateFeedbackParameters;

class CreateFeedbackRequest extends SchemaParams
{
    public function getParameters()
    {
        $data = $this->getData();

        return new CreateFeedbackParameters(
            $data['type_feedback'],
            $data['description'],
            $data['profile_id'] ?? null,
            $data['email'] ?? null
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(FeedbackBundle::class, './definitions/request/CreateFeedback.yml');
    }
}