<?php
namespace CASS\Domain\Bundles\Theme\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use CASS\Domain\Bundles\Theme\Tests\ThemeMiddlewareTest;

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