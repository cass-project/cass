<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Theme;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikeThemeMiddlewareTestCase;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
/**
 * @backupGlobals disabled
 */
class AddLikeThemeTest extends LikeThemeMiddlewareTestCase
{
    public function test200()
    {
        $theme = SampleThemesFixture::getTheme(1);
        $this->requestLikeTheme($theme->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 1,
                    'dislikes' => 0,
                    'attitude' => [
                        'state' => 'liked',
                        'likes' => 1,
                        'dislikes' => 0,
                    ]
                ],
            ])
            ->expectStatusCode(200);
    }

    public function testUnAuth200()
    {
        $theme = SampleThemesFixture::getTheme(1);
        $this->requestLikeTheme($theme->getId())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 1,
                    'dislikes' => 0,
                    'attitude' => [
                        'state' => 'liked',
                        'likes' => 1,
                        'dislikes' => 0,
                    ]
                ],
            ])
            ->expectStatusCode(200);
    }
    public function test404()
    {
        $this->requestLikeTheme(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

    public function test409()
    {
        $themeId = SampleThemesFixture::getTheme(1)->getId();
        $this->upFixture(new DemoAttitudeFixture());

        $this->requestLikeTheme($themeId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409);
    }
}