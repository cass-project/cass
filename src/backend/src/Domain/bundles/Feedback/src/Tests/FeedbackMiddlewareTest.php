<?php


namespace Domain\Feedback\Tests;


use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Feedback\Tests\Fixture\DemoFeedbackFixture;

/**
 * @backupGlobals disabled
 */
class FeedbackMiddlewareTest extends MiddlewareTestCase
{
  protected function getFixtures(): array{
    return [
      new DemoFeedbackFixture()
    ];
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

  public function testFeedbackDelete200()
  {
    $feedbackId = DemoFeedbackFixture::getFeedback(1)->getId();

    return $this->requestFeedbackDelete($feedbackId)->execute()
      ->expectJSONContentType()
      ->expectStatusCode(200)
      ->expectJSONBody(['success' => true]);
  }

  public function testFeedbackDelete404()
  {
    return $this->requestFeedbackDelete(99999)->execute()
                ->expectJSONContentType()
                ->expectStatusCode(404)
                ->expectJSONBody(['success' => false]);
  }

  protected function requestFeedbackCreate(array $json):RESTRequest
  {
    return $this->request('PUT','/feedback/create')->setParameters($json);
  }

  protected function requestFeedbackDelete(int $feedbackId)
  {
    return $this->request('DELETE',sprintf("/feedback/%s/cancel",$feedbackId));
  }

}