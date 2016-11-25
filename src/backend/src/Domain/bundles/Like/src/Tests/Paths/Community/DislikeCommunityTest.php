<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Community;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Like\Tests\LikeCommunityMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class DislikeCommunityTest extends LikeCommunityMiddlewareTestCase
{
    public function testAuth200()
    {
        $this->requestDisLikeCommunity(SampleCommunitiesFixture::getCommunity(1)->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 0,
                    'dislikes' => 1,
                ],
            ])
            ->expectStatusCode(200);
    }

    public function testUnAuth200()
    {
        $this->requestDisLikeCommunity(SampleCommunitiesFixture::getCommunity(1)->getId())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 0,
                    'dislikes' => 1,
                ],
            ])
            ->expectStatusCode(200);
    }

    public function test403()
    {
        $this->requestDisLikeCommunity(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }
}