<?php
namespace Domain\Theme\Tests;

use CASS\Application\PHPUnit\RESTRequest\RESTRequest;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use CASS\Application\PHPUnit\TestCase\MiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
abstract class ThemeMiddlewareTest extends MiddlewareTestCase
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