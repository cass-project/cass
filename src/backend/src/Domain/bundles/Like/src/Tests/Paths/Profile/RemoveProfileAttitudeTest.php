<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Profile;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikeProfileMiddlewareTestCase;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class RemoveProfileAttitudeTest extends LikeProfileMiddlewareTestCase
{
    public function test200()
    {
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture());
        $profileId = DemoProfileFixture::getProfile()->getId();

        $this->requestRemoveProfileAttitude($profileId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true
            ])
            ->expectStatusCode(200)
        ;
    }

    /*public function test403()
    {
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture());
        $profileId = DemoProfileFixture::getProfile()->getId();

        $this->requestRemoveProfileAttitude($profileId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => false
            ])
            ->expectStatusCode(403)
        ;
    }*/
}