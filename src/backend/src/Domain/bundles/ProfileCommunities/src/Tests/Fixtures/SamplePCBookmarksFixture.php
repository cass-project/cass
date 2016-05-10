<?php
namespace Domain\ProfileCommunities\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Domain\ProfileCommunities\Service\ProfileCommunitiesService;
use Zend\Expressive\Application;

class SamplePCBookmarksFixture implements Fixture
{
    public static $bookmarks;

    public function up(Application $app, EntityManager $em)
    {
        $service = $app->getContainer()->get(ProfileCommunitiesService::class); /** @var ProfileCommunitiesService $service */

        self::$bookmarks = [
            1 => $service->joinToCommunity(SampleCommunitiesFixture::getCommunity(1)->getId()),
            2 => $service->joinToCommunity(SampleCommunitiesFixture::getCommunity(2)->getId()),
            3 => $service->joinToCommunity(SampleCommunitiesFixture::getCommunity(3)->getId()),
            4 => $service->joinToCommunity(SampleCommunitiesFixture::getCommunity(4)->getId()),
            5 => $service->joinToCommunity(SampleCommunitiesFixture::getCommunity(5)->getId()),
        ];
    }

    public static function getBookmarks(): array {
        return self::$bookmarks;
    }

    public static function getBookmark(int $index): ProfileCommunityEQ
    {
        return self::$bookmarks[$index];
    }
}