<?php
namespace Domain\Post\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Service\CollectionService;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Zend\Expressive\Application;

class DemoCollectionFixture implements Fixture
{
    static private $collection;

    static public function getCollection():Collection {
        return self::$collection;
    }

    public function up(Application $app, EntityManager $em) {
        $authorProfileId = DemoProfileFixture::getProfile()->getId();
        $collectionService = $app->getContainer()->get(CollectionService::class); /** @var CollectionService $collectionService */
        
        $collectionParameters = (new CreateCollectionParameters(
            $authorProfileId,
            'test',
            'testDescr',
            DemoThemeFixtures::getTheme()->getId()
        ));

        self::$collection = $collectionService->createCommunityCollection(
            DemoCommunityFixture::getCommunity()->getId()
            , $collectionParameters
        );
    }
}