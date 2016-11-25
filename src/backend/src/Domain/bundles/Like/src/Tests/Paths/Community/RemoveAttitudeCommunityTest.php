<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Community;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikeCommunityMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class RemoveAttitudeCommunityTest extends LikeCommunityMiddlewareTestCase
{
    public function test200()
    {
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture());
        $communityId = SampleCommunitiesFixture::getCommunity(2)->getId();

        $this->requestRemoveCommunityAttitude($communityId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->dump()
            ->expectJSONBody([
                'success' => true,
            ])
            ->expectStatusCode(200);
    }

    public function test404()
    {
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture());

        $this->requestRemoveCommunityAttitude(self::NOT_FOUND_ID)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }
}