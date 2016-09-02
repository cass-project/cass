<?php
namespace CASS\Domain\Bundles\Theme\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use CASS\Domain\Bundles\Theme\Tests\ThemeMiddlewareTest;

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