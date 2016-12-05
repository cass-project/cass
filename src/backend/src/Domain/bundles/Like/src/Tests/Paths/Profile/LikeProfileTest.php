<?php
namespace CASS\Domain\Bundles\Like\Tests\Paths\Profile;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikeProfileMiddlewareTestCase;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class LikeProfileTest extends LikeProfileMiddlewareTestCase
{

    public function testAuth200()
    {
        $this->requestLikeProfile(DemoProfileFixture::getProfile()->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 1,
                    'dislikes' => 0,
                    'attitude' => [
                        'state' => 'liked',
                        'likes' => 1,
                        'dislikes' => 0,
                    ]
                ],
            ])
            ->expectStatusCode(200);
    }

    public function testUnAuth200()
    {
        $this->requestLikeProfile(DemoProfileFixture::getProfile()->getId())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 1,
                    'dislikes' => 0,
                    'attitude' => [
                        'state' => 'liked',
                        'likes' => 1,
                        'dislikes' => 0,
                    ]
                ],
            ])
            ->expectStatusCode(200);
    }

    public function testProfile404()
    {
        $this->requestLikeProfile(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

    public function test409()
    {
        $profileId = DemoProfileFixture::getProfile()->getId();
        $this->upFixture(new DemoAttitudeFixture());

        $this->requestLikeProfile($profileId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409);
    }
}