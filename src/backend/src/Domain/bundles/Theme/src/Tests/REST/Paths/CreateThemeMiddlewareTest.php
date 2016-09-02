<?php
namespace CASS\Domain\Bundles\Theme\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use CASS\Domain\Bundles\Theme\Tests\ThemeMiddlewareTest;

/**
 * @backupGlobals disabled
 */
final class CreateThemeMiddlewareTest extends ThemeMiddlewareTest
{
    public function testCreateTheme403()
    {
        $json = [
            'title' => 'Theme 1',
            'description' => 'My Demo Theme Description',
            'parent_id' => 0,
        ];

        $this->requestCreateTheme($json)
            ->execute()
            ->expectAuthError();
    }

    public function testCreateTheme200()
    {
        $json = [
            'title' => 'Theme 1',
            'description' => 'My Demo Theme Description',
            'parent_id' => 0,
        ];

        $this->requestCreateTheme($json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'title' => $json['title'],
                    'url' => $this->expectString(),
                    'parent_id' => null,
                    'description' => $json['description'],
                    'preview' => Theme::DEFAULT_PREVIEW,
                ],
            ]);
    }

    public function testCreateThemeRU2En200()
    {
        $json = [
            'title' => 'съешь еще этих французских булок, да выпей чаю, я',
            'description' => 'My Demo Theme Description',
            'parent_id' => 0,
        ];

        $this->requestCreateTheme($json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'title' => $json['title'],
                    'url' => 's_yesh_yeshche_etikh_frantsuzskikh_bulok_da_vypey_chayu_ya',
                    'parent_id' => null,
                    'description' => $json['description'],
                    'preview' => Theme::DEFAULT_PREVIEW,
                ],
            ]);
    }
}