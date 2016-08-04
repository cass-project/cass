<?php
namespace Domain\Theme\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Domain\Theme\Tests\ThemeMiddlewareTest;

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