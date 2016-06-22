<?php
namespace Domain\Theme\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Application\PHPUnit\TestCase\MiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class ThemeMiddlewareTest extends MiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture()
        ];
    }

    public function testCreateTheme()
    {
        $json = [
            'title' => 'Theme 1',
            'description' => 'My Demo Theme Description',
            'parent_id' => 0
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
                    'parent_id' => null,
                    'description' => $json['description']
                ]
            ]);
    }

    public function testUnAuthCreateTheme()
    {
        $json = [
            'title' => 'Theme 1',
            'description' => 'My Demo Theme Description',
            'parent_id' => 0
        ];

        $this->requestCreateTheme($json)
            ->execute()
            ->expectAuthError();
    }

    private function requestCreateTheme(array $json): RESTRequest
    {
        return $this->request('PUT', '/protected/theme/create')
            ->setParameters($json);
    }

    public function testDeleteTheme()
    {
        $this->requestDeleteTheme(SampleThemesFixture::getTheme(1)->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody(['success' => TRUE]);
    }

    public function testUnAuthDeleteTheme403()
    {
        $this->requestDeleteTheme(SampleThemesFixture::getTheme(1)->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testDeleteTheme404()
    {
        $this->requestDeleteTheme(10000)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectJSONBody(['success' => FALSE]);
    }

    public function testGetTheme404()
    {
        $this->requestGetTheme(999999)
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectJSONBody(['success' => FALSE]);
    }

    private function requestGetTheme(int $themeId):RESTRequest
    {
        return $this->request('GET', sprintf('/theme/%d/get', $themeId));
    }

    public function testGetThemeList()
    {
        $this->requestGetThemeList()->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody(['success' => true]);
    }

    public function testMoveTheme()
    {
        $this->upFixture(new SampleThemesFixture());

        $FixtureThemeFrom = SampleThemesFixture::getTheme(1);
        $FixtureThemeTo = SampleThemesFixture::getTheme(2);

        $this->requestPostMoveTheme($FixtureThemeFrom->getId(), $FixtureThemeTo->getId(), 0)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody(['success' => true]);
    }

    public function testUnAuthThemeMove()
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

        $this->requestPostMoveTheme(999999999, $FixtureThemeTo->getId(), 0)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectJSONBody(['success' => FALSE]);
    }

    private function requestPostMoveTheme(int $themeId, int $parentThemeId, int $position):RESTRequest
    {
        return $this->request('POST',
            sprintf('/protected/theme/%d/move/under/%d/in-position/%d',
                $themeId,
                $parentThemeId,
                $position)
        );
    }

    public function testGetThemeTree()
    {
        return $this->requestGetThemeTree()
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody(['success' => true]);
    }

    private function requestGetThemeTree():RESTRequest
    {
        return $this->request('GET', '/theme/get/tree');
    }

    public function testThemeUpdate()
    {
        $ThemeFixture = SampleThemesFixture::getTheme(1);

        $json = [
            'title' => 'Theme 1',
            'description' => 'My Demo Theme Description',
            'parent_id' => 0
        ];

        $this->requestPostUpdateTheme($ThemeFixture->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody(['success' => true]);
    }

    public function testUnAuthThemeUpdate()
    {
        $ThemeFixture = SampleThemesFixture::getTheme(1);

        $json = [
            'title' => 'Theme 1',
            'description' => 'My Demo Theme Descrition',
            'parent_id' => 0
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
            'parent_id' => 0
        ];

        $this->requestPostUpdateTheme(1000, $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectJSONBody(['success' => FALSE]);
    }

    private function requestPostUpdateTheme(int $themeId, array $json):RESTRequest
    {
        return $this->request('POST', sprintf('/protected/theme/%d/update', $themeId))
            ->setParameters($json);
    }

    private function requestGetThemeList():RESTRequest
    {
        return $this->request('GET', '/theme/get/list-all');
    }

    private function requestDeleteTheme(int $themeId):RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/theme/%d/delete', $themeId));
    }

    public function testGetTheme()
    {
        $FixtureTheme = SampleThemesFixture::getTheme(2);

        $this->requestGetTheme($FixtureTheme->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $FixtureTheme->getId(),
                    'title' => $FixtureTheme->getTitle(),
                    'parent_id' => NULL,
                    'description' => $FixtureTheme->getDescription()
                ]
            ]);
    }
}