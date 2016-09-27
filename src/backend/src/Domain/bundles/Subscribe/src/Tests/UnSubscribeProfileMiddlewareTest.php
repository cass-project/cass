<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;

/**
 * @backupGlobals disabled
 */
class UnSubscribeProfileMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testUnSubscribeProfileSuccess200()
    {
        $account = DemoAccountFixture::getAccount();
        $this->requestUnSubscribeProfile($account->getCurrentProfile()->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

    public function testUnSubscribeProfileNotAuth403()
    {
        $account = DemoAccountFixture::getAccount();
        $this->requestUnSubscribeProfile($account->getCurrentProfile()->getId())
            ->execute()
            ->expectStatusCode(403);
    }

    public function testUnSubscribeProfileNotFound404()
    {
        $account = DemoAccountFixture::getAccount();
        $this->requestUnSubscribeProfile(999999)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(404);
    }


}