<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Community;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikeCommunityMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class LikeCommunityTest extends LikeCommunityMiddlewareTestCase
{
    public function testAuth200()
    {
        $this->requestLikeCommunity(SampleCommunitiesFixture::getCommunity(1)->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 1,
                    'dislikes' => 0,
                ],
            ])
            ->expectStatusCode(200);
    }

    public function testUnAuth200()
    {
        $this->requestLikeCommunity(SampleCommunitiesFixture::getCommunity(1)->getId())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 1,
                    'dislikes' => 0,
                ],
            ])
            ->expectStatusCode(200);
    }

    public function test403()
    {
        $this->requestLikeCommunity(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

    public function test409()
    {
        $communityId = SampleCommunitiesFixture::getCommunity(2)->getId();
        $this->upFixture(new DemoAttitudeFixture());

        $this->requestLikeCommunity($communityId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409);
    }
}