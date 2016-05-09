<?php
namespace Domain\Community\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Community\Parameters\CreateCommunityParameters;
use Domain\Community\Service\CommunityService;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Expressive\Application;

class SampleCommunitiesFixture implements Fixture
{
    private static $communities;

    public function up(Application $app, EntityManager $em) {
        $themes = SampleThemesFixture::getThemes();
        $communityService = $app->getContainer()->get(CommunityService::class); /** @var CommunityService $communityService */

        $theme = $themes['themes_root'][1]; /** @var Theme $theme */

        self::$communities = [
            1 => $communityService->createCommunity(new CreateCommunityParameters('Community 1', 'My Community 1', $theme->getId())),
            2 => $communityService->createCommunity(new CreateCommunityParameters('Community 2', 'My Community 2', $theme->getId())),
            3 => $communityService->createCommunity(new CreateCommunityParameters('Community 3', 'My Community 3', $theme->getId())),
            4 => $communityService->createCommunity(new CreateCommunityParameters('Community 4', 'My Community 4', $theme->getId())),
            5 => $communityService->createCommunity(new CreateCommunityParameters('Community 5', 'My Community 5', $theme->getId())),
        ];
    }

    public static function getCommunities(): array {
        return self::$communities;
    }
}