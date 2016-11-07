<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Fixtures;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use CASS\Util\Entity\IdEntity\IdEntity;
use Doctrine\ORM\EntityManager;
use ZEA2\Platform\Bundles\PHPUnit\Fixture;
use Zend\Expressive\Application;

class DemoSubscribeFixture implements Fixture
{
    private $subscribes;

    public function getSubscribes(string $type = 'theme'): array
    {
        return $this->subscribes[$type];
    }

    public function getSubscribe(string $type, int $index): Subscribe
    {
        return $this->subscribes[$type][$index - 1];
    }

    public function up(Application $app, EntityManager $em)
    {
        $subscribeService = $app->getContainer()->get(SubscribeService::class);
        
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();
        $theme = SampleThemesFixture::getTheme(1);
        $collections = SampleCollectionsFixture::getCommunityCollections();
        $collection = array_shift($collections);
        $subscribeProfile = DemoProfileFixture::getProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->subscribes['theme'][] = $subscribeService->subscribeTheme($profile, $theme);
        $this->subscribes['profile'][] = $subscribeService->subscribeProfile($profile, $subscribeProfile);
        $this->subscribes['collection'][] = $subscribeService->subscribeCollection($profile, $collection);
        $this->subscribes['community'][] = $subscribeService->subscribeCommunity($profile, $community);
    }

}