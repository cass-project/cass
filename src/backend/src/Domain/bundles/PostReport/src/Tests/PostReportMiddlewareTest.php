<?php
namespace Domain\PostReport\Tests;


use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Post\Tests\Fixtures\DemoPostFixture;
use Domain\PostReport\Entity\PostReport;
use Domain\PostReport\Tests\Fixtures\DemoPostReportsFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
/**
 * @backupGlobals disabled
 */
class PostReportMiddlewareTest extends MiddlewareTestCase
{
  protected function getFixtures(): array{
   return [
     new DemoAccountFixture(),
     new DemoProfileFixture(),
     new DemoPostReportsFixture()
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

  public function testGetPostsReports200()
  {

    $censoredPostReportDescription = DemoPostReportsFixture::getPostReport(1)->getDescription();

    $this->requestGetPostRequest(PostReport::TypeCensored, 0, 10)
      ->execute()
      ->dump()
      ->expectStatusCode(200)
      ->expectJSONContentType()
      ->expectJSONBody([
        'success' => true,
                       ])
      ->expect(function(array $jsonResponse) use ($censoredPostReportDescription) {
        $postReports = $jsonResponse['entities'];

        $this->assertTrue(is_array($postReports));
        $this->assertEquals(1, count($postReports));
        $this->assertEquals($censoredPostReportDescription, $postReports[1]['description']);
      })
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
                          sprintf('/post-report/list/type/%s/offset/%s/limit/%s/',
                                  $type, $offset, $limit
                                  ));
  }

}