<?php
namespace Domain\Theme\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Domain\Theme\Tests\ThemeMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class MoveThemeMiddlewareTest extends ThemeMiddlewareTest
{
    public function testMoveTheme403()
    {
        $this->upFixture(new SampleThemesFixture());

        $FixtureThemeFrom = SampleThemesFixture::getTheme(1);
        $FixtureThemeTo = SampleThemesFixture::getTheme(2);

        $this->requestPostMoveTheme($FixtureThemeFrom->getId(), $FixtureThemeTo->getId(), 0)
            ->execute()
            ->expectAuthError();
    }

    public function testMoveTheme404()
    {
        $this->upFixture(new SampleThemesFixture());

        $FixtureThemeTo = SampleThemesFixture::getTheme(2);

        $this->requestPostMoveTheme(self::NOT_FOUND_ID, $FixtureThemeTo->getId(), 0)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectNotFoundError();
    }

    public function testMoveTheme200()
    {
        $this->upFixture(new SampleThemesFixture());

        $FixtureThemeFrom = SampleThemesFixture::getTheme(1);
        $FixtureThemeTo = SampleThemesFixture::getTheme(2);

        $this->requestPostMoveTheme($FixtureThemeFrom->getId(), $FixtureThemeTo->getId(), 0)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
            ]);
    }
}