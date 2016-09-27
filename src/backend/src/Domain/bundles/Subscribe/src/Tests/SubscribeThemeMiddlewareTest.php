<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
/**
 * @backupGlobals disabled
 */
class SubscribeThemeMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testSubscribeTheme200()
    {
        $account = DemoAccountFixture::getAccount();

        $theme = SampleThemesFixture::getTheme(1);
        $this->requestSubscribeTheme($theme->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

    public function testSubscrubeThemeUnAuth403()
    {
        $theme = SampleThemesFixture::getTheme(1);
        $this->requestSubscribeTheme($theme->getId())
            ->execute()
            ->expectStatusCode(403)
            ->expectJSONContentType()
            ;
    }

    public function testSubscribeThemeNotFound404()
    {
        $account = DemoAccountFixture::getAccount();
        $this->requestSubscribeTheme(99999)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(404)
            ;
    }
}
