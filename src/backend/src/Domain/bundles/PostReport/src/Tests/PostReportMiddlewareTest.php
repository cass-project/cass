<?php
namespace Domain\PostReport\Tests;


use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
/**
 * @backupGlobals disabled
 */
class PostReportMiddlewareTest extends MiddlewareTestCase
{
  protected function getFixtures(): array{
   return [
     new DemoAccountFixture(),
     new DemoProfileFixture()
   ];
  }

  public function testCreatePostReport403()
  {
    $json =[
      'profile_id'   => 1,
      'report_types' => [0],
      'description'  => 'string'
    ];

    return $this->requestCreatePostReport($json)
      ->execute()
      ->expectAuthError()
      ;
  }
  public function testCreatePostReport200()
  {
    $json =[
      'profile_id'   => DemoProfileFixture::getProfile()->getId(),
      'report_types' => [0],
      'description'  => 'string'
    ];

    return $this->requestCreatePostReport($json)
      ->auth(DemoAccountFixture::getAccount()->getAPIKey())
      ->execute()
      ->expectJSONContentType()
      ->expectStatusCode(200)
      ->expectJSONBody([
                         'success' => TRUE,
        ])
      ;
  }
  public function testCreatePostReport404()
  {
    $json =[
      'profile_id'   => 2,
      'report_types' => [0],
      'description'  => 'string'
    ];

    return $this->requestCreatePostReport($json)
      ->auth(DemoAccountFixture::getAccount()->getAPIKey())
      ->execute()
      ->expectJSONContentType()
      ->expectStatusCode(404)
      ->expectJSONBody([
                         'success' => false,
        ])
      ;
  }

  protected function requestCreatePostReport(array $json)
  {
    return $this->request('PUT','/protected/post-report/create')
      ->setParameters($json);
  }


  protected function requestGetPostRequest($type,$offset,$limit)
  {
    return $this->request('GET',
                          sprintf('/protected/post-report/list/type/%s/offset/%s/limit/%s/',
                                  $type, $offset, $limit
                                  ));
  }

}