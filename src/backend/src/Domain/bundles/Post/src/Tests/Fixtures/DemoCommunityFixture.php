<?php


namespace Domain\Post\Tests\Fixtures;


use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Community\Entity\Community;
use Domain\Community\Service\CommunityService;
use Zend\Expressive\Application;

class DemoCommunityFixture implements Fixture
{

  /** @var  Community */
  static private $community;

  public function up(Application $app, EntityManager $em){

    /** @var CommunityService $communityService */
    $communityService = $app->getContainer()->get(CommunityService::class);

    self::$community = $communityService->createCommunity(
      'Title',
      'Description',
      DemoThemeFixtures::getTheme()->getId()
    );
  }


  static public function getCommunity():Community
  {
    return self::$community;
  }



}