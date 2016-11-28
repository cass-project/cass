<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Theme;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikeThemeMiddlewareTestCase;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
/**
 * @backupGlobals disabled
 */
class AddDisLikeThemeTest extends LikeThemeMiddlewareTestCase
{
    public function test200()
    {
        $theme = SampleThemesFixture::getTheme(1);
        $this->requestDisLikeTheme($theme->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 0,
                    'dislikes' => 1,
                ],
            ])
            ->expectStatusCode(200);
    }

    public function testUnAuth200()
    {
        $theme = SampleThemesFixture::getTheme(1);
        $this->requestDisLikeTheme($theme->getId())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 0,
                    'dislikes' => 1,
                ],
            ])
            ->expectStatusCode(200);
    }

    public function test404()
    {
        $this->requestDisLikeTheme(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

    public function test409()
    {
        $themeId = SampleThemesFixture::getTheme(2)->getId();
        $this->upFixture(new DemoAttitudeFixture());

        $this->requestDisLikeTheme($themeId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409);
    }
}