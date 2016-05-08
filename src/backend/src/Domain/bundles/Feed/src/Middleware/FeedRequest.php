<?php
namespace Domain\Feed\Middleware;

use Application\REST\Service\JSONSchema;
use Domain\Request\Params\SchemaParams;
use Domain\Feed\Feed\Criteria\SeekCriteria;
use Domain\Feed\Feed\CriteriaRequest;
use Domain\Feed\FeedBundle;

class FeedRequest extends SchemaParams
{
    public function getParameters() {
        return [
            'criteria' => $this->getCriteriaRequest()
        ];
    }
    
    public function getCriteriaRequest(): CriteriaRequest {
        $request = json_decode(json_encode($this->getData()->criteria), true);
        $criteriaRequest = new CriteriaRequest();

        if(SeekCriteria::isAvailable($request)) {
            $criteriaRequest->addCriteria(new SeekCriteria($request));
        }

        return $criteriaRequest;
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(FeedBundle::class, './definitions/request/FeedCriteriaRequest.yml');
    }
}