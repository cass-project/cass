<?php
namespace CASS\Domain\Theme\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use CASS\Domain\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
abstract class ThemeMiddlewareTest extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture()
        ];
    }

    protected function requestCreateTheme(array $json): RESTRequest
    {
        return $this->request('PUT', '/protected/theme/create')
            ->setParameters($json);
    }

    protected function requestGetTheme(int $themeId):RESTRequest
    {
        return $this->request('GET', sprintf('/theme/%d/get', $themeId));
    }
    
    protected function requestPostMoveTheme(int $themeId, int $parentThemeId, int $position):RESTRequest
    {
        return $this->request('POST',
            sprintf('/protected/theme/%d/move/under/%d/in-position/%d',
                $themeId,
                $parentThemeId,
                $position)
        );
    }
    
    protected function requestGetThemeTree():RESTRequest
    {
        return $this->request('GET', '/theme/get/tree');
    }

    protected function requestPostUpdateTheme(int $themeId, array $json):RESTRequest
    {
        return $this->request('POST', sprintf('/protected/theme/%d/update', $themeId))
            ->setParameters($json);
    }

    protected function requestGetThemeList():RESTRequest
    {
        return $this->request('GET', '/theme/get/list-all');
    }

    protected function requestDeleteTheme(int $themeId):RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/theme/%d/delete', $themeId));
    }
}