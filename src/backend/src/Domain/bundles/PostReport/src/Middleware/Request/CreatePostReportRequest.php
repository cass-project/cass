<?php


namespace Domain\PostReport\Middleware\Request;


use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\JSONSchema;
use Domain\PostReport\Entity\PostReport;
use Domain\PostReport\Parameters\CreatePostReportParameters;

class CreatePostReportRequest extends SchemaParams
{
  public function getParameters(){
    if($this->getRequest()->getParsedBody()){
      $data = (array) ($this->getRequest()->getParsedBody());
    }
    else{
      $data = json_decode($this->getRequest()->getBody(), TRUE);
    }

    return new CreatePostReportParameters(
      (int) $data['profile_id'],
      (array) $data['report_types'],
      (string) $data['description']
    );
  }

  protected function getSchema(): JSONSchema
  {
    return self::getSchemaService()->getSchema(PostReport::class, './definitions/request/CreatePostReportRequest.yml');
  }

}