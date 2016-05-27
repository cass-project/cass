<?php


namespace Domain\Post\Tests\Fixtures;


use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Service\CollectionService;
use Zend\Expressive\Application;

class DemoCollectionFixture implements Fixture
{
  static private $collection;

  static public function getCollection():Collection
  {
    return self::$collection;
  }
  public function up(Application $app, EntityManager $em){
    /** @var CollectionService $collectionService */
    $collectionService = $app->getContainer()->get(CollectionService::class);


    $collectionParameters = (new CreateCollectionParameters('test',
                                                            'testDescr',
                                                            DemoThemeFixtures::getTheme()->getId()
    ));

    self::$collection = $collectionService->createCommunityCollection(
      DemoCommunityFixture::getCommunity()->getId()
      ,$collectionParameters);
  }


}