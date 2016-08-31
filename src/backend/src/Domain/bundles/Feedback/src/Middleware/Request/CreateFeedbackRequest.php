<?php
namespace Domain\Feedback\Middleware\Request;

use CASS\Application\REST\Request\Params\SchemaParams;
use CASS\Application\REST\Service\JSONSchema;
use Domain\Feedback\FeedbackBundle;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackParameters;

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