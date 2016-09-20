<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Fixtures;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use Doctrine\ORM\EntityManager;
use ZEA2\Platform\Bundles\PHPUnit\Fixture;
use Zend\Expressive\Application;

class DemoSubscribeFixture implements Fixture
{
    static private $subscribes;


    static public function getSubscribes(string $type = 'theme'): Subscribe
    {
        return self::$subscribes[$type][0];
    }

    public function up(Application $app, EntityManager $em)
    {
        $subscribeService = $app->getContainer()->get(SubscribeService::class);
        
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();
        $theme = SampleThemesFixture::getTheme(1);
        self::$subscribes['theme'][0] = $subscribeService->subscribeTheme($profile, $theme);

        $subscribeProfile = DemoProfileFixture::getProfile();
        self::$subscribes['profile'][0] = $subscribeService->subscribeProfile($profile, $subscribeProfile);

        $collections = SampleCollectionsFixture::getCommunityCollections();
        $collection = array_shift($collections);
        self::$subscribes['collection'][0] = $subscribeService->subscribeCollection($profile, $collection);

        $community = SampleCommunitiesFixture::getCommunity(1);
        self::$subscribes['community'][0] = $subscribeService->subscribeCommunity($profile, $community);
    }

}