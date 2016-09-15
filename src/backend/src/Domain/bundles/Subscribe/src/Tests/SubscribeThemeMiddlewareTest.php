<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
/**
 * @backupGlobals disabled
 */
class SubscribeThemeMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testSubscribeTheme()
    {
        $account = DemoAccountFixture::getAccount();

        $theme = SampleThemesFixture::getTheme(1);

        $this->requestSubscribeTheme($theme->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->dump()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }
}