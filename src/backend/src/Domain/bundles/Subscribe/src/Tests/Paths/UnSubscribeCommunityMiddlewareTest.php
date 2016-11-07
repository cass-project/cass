<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Subscribe\Tests\Fixtures\DemoSubscribeFixture;
use CASS\Domain\Bundles\Subscribe\Tests\SubscribeMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class UnSubscribeCommunityMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function test200()
    {
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $subscribe = $fixture->getSubscribe('community', 1);
        $account = DemoAccountFixture::getAccount();

        $this->requestUnSubscribeCommunity($subscribe->getSubscribeId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

    public function test403()
    {
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $subscribe = $fixture->getSubscribe('community', 1);

        $this->requestUnSubscribeCollection($subscribe->getSubscribeId())
            ->execute()
            ->expectAuthError();
    }

    public function test404()
    {
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $account = DemoAccountFixture::getAccount();

        $this->requestUnSubscribeCollection(self::NOT_FOUND_ID)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }
}