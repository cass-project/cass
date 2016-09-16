<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Fixtures;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
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

    public function getSubscribe(int $idx): Subscribe
    {
        return self::$subscribes[$idx];
    }

    public function getSubscribes(): array
    {
        return self::$subscribes;
    }

    public function up(Application $app, EntityManager $em)
    {
        $subscribeService = $app->getContainer()->get(SubscribeService::class);
        
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();
        $theme = SampleThemesFixture::getTheme(1);

        self::$subscribes[] = $subscribeService->subscribeTheme($profile, $theme);

        $subscribeProfile = DemoProfileFixture::getProfile();

        self::$subscribes[] = $subscribeService->subscribeProfile($profile, $subscribeProfile);

    }

}