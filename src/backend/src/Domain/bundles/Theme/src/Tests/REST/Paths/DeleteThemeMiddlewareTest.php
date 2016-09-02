<?php
namespace CASS\Domain\Bundles\Theme\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use CASS\Domain\Bundles\Theme\Tests\ThemeMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class DeleteThemeMiddlewareTest extends ThemeMiddlewareTest
{
    public function testUnAuthDeleteTheme403()
    {
        $this->requestDeleteTheme(SampleThemesFixture::getTheme(1)->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testDeleteTheme404()
    {
        $this->requestDeleteTheme(self::NOT_FOUND_ID)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectNotFoundError();
    }

    public function testDeleteTheme200()
    {
        $this->requestDeleteTheme(SampleThemesFixture::getTheme(1)->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
            ]);
    }
}