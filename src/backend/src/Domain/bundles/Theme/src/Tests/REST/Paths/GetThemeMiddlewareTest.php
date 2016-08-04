<?php
namespace Domain\Theme\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Domain\Theme\Tests\ThemeMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class GetThemeMiddlewareTest extends ThemeMiddlewareTest
{
    public function testGetTheme404()
    {
        $this->requestGetTheme(self::NOT_FOUND_ID)
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectNotFoundError();
    }

    public function testGetTheme200()
    {
        $fixtureTheme = SampleThemesFixture::getTheme(2);

        $this->requestGetTheme($fixtureTheme->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $fixtureTheme->getId(),
                    'title' => $fixtureTheme->getTitle(),
                    'parent_id' => null,
                    'description' => $fixtureTheme->getDescription(),
                ],
            ]);
    }
}