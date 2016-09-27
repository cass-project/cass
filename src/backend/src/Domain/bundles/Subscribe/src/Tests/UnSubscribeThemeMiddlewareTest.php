<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class UnSubscribeThemeMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testUnSubscribeThemeSuccess200()
    {
        $account = DemoAccountFixture::getAccount();
        $theme = SampleThemesFixture::getTheme(1);

        $this->requestUnSubscribeTheme($theme->getId())
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
        $theme = SampleThemesFixture::getTheme(1);

        $this->requestUnSubscribeTheme($theme->getId())
            ->execute()
            ->expectStatusCode(403);
    }

    public function testUnSubscribeThemeNotFound404()
    {
        $account = DemoAccountFixture::getAccount();

        $this->requestUnSubscribeTheme(9999)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(404);
    }
}