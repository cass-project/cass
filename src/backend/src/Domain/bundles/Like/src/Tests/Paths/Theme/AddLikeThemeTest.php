<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Theme;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
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
                ],
            ])
            ->expectStatusCode(200);
    }
}