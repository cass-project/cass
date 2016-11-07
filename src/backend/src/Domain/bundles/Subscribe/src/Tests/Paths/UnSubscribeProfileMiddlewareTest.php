<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Subscribe\Tests\Fixtures\DemoSubscribeFixture;
use CASS\Domain\Bundles\Subscribe\Tests\SubscribeMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class UnSubscribeProfileMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testUnSubscribeProfileSuccess200()
    {
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $subscribe = $fixture->getSubscribe('profile', 1);
        $account = DemoAccountFixture::getAccount();

        $this->requestUnSubscribeProfile($subscribe->getSubscribeId())
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
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $subscribe = $fixture->getSubscribe('community', 1);

        $this->requestUnSubscribeProfile($subscribe->getSubscribeId())
            ->execute()
            ->expectAuthError();
    }

    public function testUnSubscribeProfileNotFound404()
    {
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $account = DemoAccountFixture::getAccount();

        $this->requestUnSubscribeProfile(self::NOT_FOUND_ID)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }
}