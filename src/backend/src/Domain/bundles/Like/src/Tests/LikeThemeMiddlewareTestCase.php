<?php
namespace CASS\Domain\Bundles\Like\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class LikeThemeMiddlewareTestCase extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array{
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
        ];
    }

    public function requestLikeTheme(int $themeId){
        return $this->request('PUT', sprintf('/like/theme/%d/add-like', $themeId));
    }

    public function requestDisLikeTheme(int $themeId){
        return $this->request('PUT', sprintf('/like/theme/%d/add-dislike', $themeId));
    }

    public function requestRemoveThemeAttitude(int $themeId){
        return $this->request('DELETE', sprintf('/like/theme/%d/remove-attitude', $themeId));
    }

}