<?php


namespace Domain\Feedback\Tests;


use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class FeedbackMiddlewareTest extends MiddlewareTestCase
{
  protected function getFixtures(): array{
    return [];
  }


  public function testFeedbackCreate200()
  {
    $json = [
      "profile_id"    => 0,
      "type_feedback" => 0,
      "description"   => "string"
    ];


    return $this->requestFeedbackCreate($json)->execute()
      ->expectJSONContentType()
      ->expectStatusCode(200)
      ->expectJSONBody(['success' => true])
      ->expect(function($result)use($json){
        $this->assertEquals($json['type_feedback'], $result['entity']['type']);
        $this->assertEquals($json['description'], $result['entity']['description']);
      })
      ;
  }

  public function testCreateUnknownProfile404(){
    $json = [
      "profile_id"    => 1,
      "type_feedback" => 0,
      "description"   => "string"
    ];

    return $this->requestFeedbackCreate($json)->execute()
                ->expectJSONContentType()
                ->expectStatusCode(404)
                ->expectJSONBody(['success' => false])
      ;
  }

  protected function requestFeedbackCreate(array $json):RESTRequest
  {
    return $this->request('PUT','/feedback/create')->setParameters($json);
  }

}