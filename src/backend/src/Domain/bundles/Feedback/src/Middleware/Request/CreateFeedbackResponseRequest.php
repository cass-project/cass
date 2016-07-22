<?php
namespace Domain\Feedback\Middleware\Request;

use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\JSONSchema;
use Domain\Feedback\FeedbackBundle;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackResponseParameters;

class CreateFeedbackResponseRequest extends SchemaParams
{
    public function getParameters()
    {
        $data = $this->getData();

        return new CreateFeedbackResponseParameters(
            $data['description'],
            $data['feedback_id']
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(FeedbackBundle::class, './definitions/request/CreateFeedbackResponse.yml');
    }
}