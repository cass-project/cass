<?php
namespace Domain\Theme\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Domain\Theme\Tests\ThemeMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class UpdateThemeMiddlewareTest extends ThemeMiddlewareTest
{
    public function testThemeUpdate403()
    {
        $ThemeFixture = SampleThemesFixture::getTheme(1);

        $json = [
            'title' => 'Theme 1',
            'description' => 'My Demo Theme Descrition',
            'parent_id' => 0,
        ];

        $this->requestPostUpdateTheme($ThemeFixture->getId(), $json)
            ->execute()
            ->expectAuthError();
    }

    public function testThemeUpdate404()
    {

        $json = [
            'title' => 'Theme 1',
            'description' => 'My Demo Theme Description',
            'parent_id' => 0,
        ];

        $this->requestPostUpdateTheme(1000, $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectNotFoundError();
    }

    public function testThemeUpdate200()
    {
        $ThemeFixture = SampleThemesFixture::getTheme(1);

        $json = [
            'title' => 'Theme 1',
            'description' => 'My Demo Theme Description',
            'parent_id' => 0,
        ];

        $this->requestPostUpdateTheme($ThemeFixture->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
            ]);
    }
}