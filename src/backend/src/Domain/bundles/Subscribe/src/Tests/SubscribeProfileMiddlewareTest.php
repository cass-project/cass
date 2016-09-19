<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
/**
 * @backupGlobals disabled
 */
class SubscribeProfileMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testSubscribeProfileSuccess200()
    {
        $account = DemoAccountFixture::getAccount();
        $this->requestSubscribeProfile($account->getCurrentProfile()->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

    public function testSubscribeProfileUnAuth403()
    {
        $account = DemoAccountFixture::getAccount();
        $this->requestSubscribeProfile($account->getCurrentProfile()->getId())
            ->execute()
            ->expectStatusCode(403);
    }

    public function testSubscribeProfileNotFound404()
    {
        $account = DemoAccountFixture::getAccount();
        $this->requestSubscribeProfile(99999)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(404);
    }
}