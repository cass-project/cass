<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Tests\Fixtures\DemoSubscribeFixture;
use CASS\Domain\Bundles\Subscribe\Tests\SubscribeMiddlewareTestCase;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class SubscribeThemeMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testSubscribeTheme200()
    {
        $account = DemoAccountFixture::getAccount();
        $theme = SampleThemesFixture::getTheme(1);

        $this->requestSubscribeTheme($theme->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'subscribe' => [
                    'profile_id' => $account->getCurrentProfile()->getId(),
                    'subscribe_id' => $theme->getId(),
                    'subscribe_type' => Subscribe::TYPE_THEME,
                    'entity' => [
                        'id' => $theme->getId(),
                    ],
                ]
            ]);
    }

    public function test403()
    {
        $theme = SampleThemesFixture::getTheme(1);
        $this->requestSubscribeTheme($theme->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testSubscribeThemeNotFound404()
    {
        $account = DemoAccountFixture::getAccount();
        $this->requestSubscribeTheme(self::NOT_FOUND_ID)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function test409()
    {
        $this->upFixture( $fixture = new DemoSubscribeFixture() );
        $account = DemoAccountFixture::getAccount();
        $subscribedTheme = $fixture->getSubscribe('theme', 1);
        $this->requestSubscribeTheme($subscribedTheme->getSubscribeId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
            ]);
    }
}
