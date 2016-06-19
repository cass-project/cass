<?php


namespace Domain\PostReport\Tests\Fixtures;


use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\PostReport\Entity\PostReport;
use Domain\PostReport\Parameters\CreatePostReportParameters;
use Domain\PostReport\Service\PostReportService;
use Domain\Profile\Entity\Profile;
use Zend\Expressive\Application;

class DemoPostReportsFixture implements Fixture
{
  protected static $postReports;

  static public function getPostReports(): array
  {
    return self::$postReports;
  }

  static public function getPostReport($index=0):PostReport
  {
    return self::$postReports[$index];
  }

  public function up(Application $app, EntityManager $em)
  {
    /** @var PostReportService $profile */
    $postReportService = $app->getContainer()->get(PostReportService::class);
    /** @var Profile $profile */
    $profile = DemoAccountFixture::getAccount()->getProfiles()->first();

    $reportsParameters = [
      (new CreatePostReportParameters(
        $profile->getId(),[0],'Report 1'
      )),
      (new CreatePostReportParameters(
        $profile->getId(), [PostReport::TypeCensored], 'Report 2'
      )),
      (new CreatePostReportParameters(
        $profile->getId(), [PostReport::TypeBadBehavior], 'Report 3'
      )),
      (new CreatePostReportParameters(
        $profile->getId(), [PostReport::TypeOfftop,PostReport::TypeBadBehavior], 'Report 4'
      ))
    ];

    foreach($reportsParameters as $reportParam){
      self::$postReports[] = $postReportService->createPostReport($reportParam);
    }

  }

}