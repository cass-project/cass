<?php
namespace Domain\Community\Tests\Fixtures;

use CASS\Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Community\Entity\Community;
use Domain\Community\Parameters\CreateCommunityParameters;
use Domain\Community\Service\CommunityService;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Expressive\Application;

class SampleCommunitiesFixture implements Fixture
{
    private static $communities;

    public function up(Application $app, EntityManager $em) {
        $communityService = $app->getContainer()->get(CommunityService::class); /** @var CommunityService $communityService */

        self::$communities = [
            1 => $communityService->createCommunity(new CreateCommunityParameters('Community 1', 'My Community 1', SampleThemesFixture::getTheme(1)->getId())),
            2 => $communityService->createCommunity(new CreateCommunityParameters('Community 2', 'My Community 2', SampleThemesFixture::getTheme(2)->getId())),
            3 => $communityService->createCommunity(new CreateCommunityParameters('Community 3', 'My Community 3', SampleThemesFixture::getTheme(3)->getId())),
            4 => $communityService->createCommunity(new CreateCommunityParameters('Community 4', 'My Community 4', SampleThemesFixture::getTheme(4)->getId())),
            5 => $communityService->createCommunity(new CreateCommunityParameters('Community 5', 'My Community 5', SampleThemesFixture::getTheme(5)->getId())),
        ];
    }

    public static function getCommunities(): array {
        return self::$communities;
    }

    public static function getCommunity(int $index): Community {
        return self::$communities[$index];
    }
}