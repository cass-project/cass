<?php
namespace CASS\Domain\Bundles\Feedback\Middleware\Request;

use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;
use CASS\Domain\Bundles\Feedback\FeedbackBundle;
use CASS\Domain\Bundles\Feedback\Middleware\Parameters\CreateFeedbackResponseParameters;

class CreateFeedbackResponseRequest extends SchemaParams
{
    public function getParameters()
    {
        $data = $this->getData();

        return new CreateFeedbackResponseParameters(
            $data['description'],
            (int) $data['feedback_id']
        );
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(FeedbackBundle::class, './definitions/request/CreateFeedbackResponse.yml');
    }
}