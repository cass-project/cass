<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Subscribe\Tests\Fixtures\DemoSubscribeFixture;
use CASS\Domain\Bundles\Subscribe\Tests\SubscribeMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class UnSubscribeThemeMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testUnSubscribeThemeSuccess200()
    {
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $subscribe = $fixture->getSubscribe('theme', 1);
        $account = DemoAccountFixture::getAccount();

        $this->requestUnSubscribeTheme($subscribe->getSubscribeId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

    public function testUnSubscribeThemeNotAuth403()
    {
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $subscribe = $fixture->getSubscribe('theme', 1);

        $this->requestUnSubscribeTheme($subscribe->getSubscribeId())
            ->execute()
            ->expectAuthError();
    }

    public function testUnSubscribeThemeNotFound404()
    {
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $account = DemoAccountFixture::getAccount();

        $this->requestUnSubscribeTheme(self::NOT_FOUND_ID)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }
}