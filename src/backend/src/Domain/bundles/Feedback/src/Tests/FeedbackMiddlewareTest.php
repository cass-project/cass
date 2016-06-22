<?php


namespace Domain\Feedback\Tests;


use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Feedback\Tests\Fixture\DemoFeedbackFixture;
use Domain\Feedback\Tests\Fixture\DemoFeedbackResponseFixture;

/**
 * @backupGlobals disabled
 */
class FeedbackMiddlewareTest extends MiddlewareTestCase
{
  protected function getFixtures(): array{
    return [
      new DemoFeedbackFixture(),
      new DemoFeedbackResponseFixture()
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

  public function testFeedbackHasAnswer200()
  {
    $feedbackId = DemoFeedbackFixture::getFeedback(2)->getId();

    $countResponses = count( DemoFeedbackResponseFixture::getFeedbackResponses());
    return $this->requestFeedbackHasAnswer($feedbackId)
      ->execute()
      ->expectJSONContentType()
      ->expectStatusCode(200)
      ->expectJSONBody(['success' => true])
      ->expect(function($result)use($countResponses){
        $this->assertEquals($countResponses,count($result['entities']));
      })
      ;
  }

  public function testFeedbackWithoutAnswer200()
  {
    return $this->requestFeedbacksWithoutAnswer()->execute()
      ->expectJSONContentType()
        ->expectStatusCode(200)
        ->expectJSONBody(['success' => true])
        ->expect(function($result){
          $this->assertEquals(2, count( $result['entities']));
        })
      ;
  }
  public function testFeedbackWithoutAnswerWrongResult200()
  {
    return $this->requestFeedbacksWithoutAnswer()->execute()
      ->expectJSONContentType()
        ->expectStatusCode(200)
        ->expectJSONBody(['success' => true])
        ->expect(function($result){
          $this->assertNotEquals(6666, count( $result['entities']));
        })
      ;
  }

  protected function requestFeedbackCreate(array $json):RESTRequest
  {
    return $this->request('PUT','/feedback/create')->setParameters($json);
  }

  protected function requestFeedbackDelete(int $feedbackId):RESTRequest
  {
    return $this->request('DELETE',sprintf("/feedback/%s/cancel",$feedbackId));
  }

  protected function requestFeedbackHasAnswer(int $feedbackId):RESTRequest
  {
    return $this->request('GET', sprintf("/feedback/%s/has-answer",$feedbackId));
  }

  protected function requestFeedbacksWithoutAnswer():RESTRequest
  {
    return $this->request('GET', "/feedback/without-answer");
  }

}