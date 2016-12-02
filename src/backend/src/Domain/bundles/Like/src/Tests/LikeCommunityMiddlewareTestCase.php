<?php
namespace CASS\Domain\Bundles\Like\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class LikeCommunityMiddlewareTestCase extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array{
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
        ];
    }

    public function requestLikeCommunity(int $communityId){
        return $this->request('PUT', sprintf('/like/community/%d/add-like', $communityId));
    }

    public function requestDisLikeCommunity(int $communityId){
        return $this->request('PUT', sprintf('/like/community/%d/add-dislike', $communityId));
    }

    public function requestRemoveCommunityAttitude(int $communityId){
        return $this->request('DELETE', sprintf('/like/community/%d/remove-attitude', $communityId));
    }

}