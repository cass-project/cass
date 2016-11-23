<?php
namespace CASS\Domain\Bundles\Like\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use CASS\Application\Bundles\Stage\Fixture\ThemeFixture;
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
            new SampleThemesFixture()
        ];
    }

    public function requestLikeTheme(int $profileId){
        return $this->request('PUT', sprintf('/like/theme/%d/add-like', $profileId));
    }

    /*public function requestDisLikeProfile(int $profileId){
        return $this->request('PUT', sprintf('/like/profile/%d/add-dislike', $profileId));
    }

    public function requestRemoveProfileAttitude(int $profileId){
        return $this->request('DELETE', sprintf('/like/profile/%d/remove-attitude', $profileId));
    }*/

}