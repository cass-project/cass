<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Theme;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikeThemeMiddlewareTestCase;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class RemoveAttitudeThemeTest extends LikeThemeMiddlewareTestCase
{
    public function test200()
    {
        $theme = SampleThemesFixture::getTheme(1);
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture());

        $this->requestRemoveThemeAttitude($theme->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
            ])
            ->expectStatusCode(200);
    }

    public function test404()
    {
        $this->requestRemoveThemeAttitude(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

}