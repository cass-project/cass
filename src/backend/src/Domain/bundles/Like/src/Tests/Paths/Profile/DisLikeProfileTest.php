<?php
namespace CASS\Domain\Bundles\Like\Tests\Paths\Profile;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Like\Tests\LikeProfileMiddlewareTestCase;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class DisLikeProfileTest extends LikeProfileMiddlewareTestCase
{

    public function testAuth200()
    {
        $this->requestDisLikeProfile(DemoProfileFixture::getProfile()->getId())
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
        $this->requestDisLikeProfile(DemoProfileFixture::getProfile()->getId())
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

    public function testProfile404()
    {
        $this->requestDisLikeProfile(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }
}