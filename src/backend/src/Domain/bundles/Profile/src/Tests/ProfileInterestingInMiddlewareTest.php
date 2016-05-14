<?php
namespace Domain\Profile\Tests;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class ProfileInterestingInMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testPutInterests() {
        $this->upFixture(
            new SampleThemesFixture()
        );

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $themeIds = [
            SampleThemesFixture::getTheme(1)->getId(),
            SampleThemesFixture::getTheme(2)->getId(),
            SampleThemesFixture::getTheme(3)->getId(),
        ];

        $this->requestInterestingInPUT($profile->getId(), ['theme_ids' => $themeIds])
            ->execute()
            ->expectAuthError()
        ;

        $this->requestInterestingInPUT($profile->getId(), ['theme_ids' => $themeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->expectInterestingInIds($profile->getId(), $themeIds);

        $newThemeIds = [
            SampleThemesFixture::getTheme(5)->getId(),
            SampleThemesFixture::getTheme(1)->getId(),
            SampleThemesFixture::getTheme(4)->getId(),
        ];

        $this->requestInterestingInPUT($profile->getId(), ['theme_ids' => $newThemeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->expectInterestingInIds($profile->getId(), $newThemeIds);
    }

    public function testPostInterests() {
        $this->upFixture(
            new SampleThemesFixture()
        );

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $themeIds = [
            SampleThemesFixture::getTheme(1)->getId(),
            SampleThemesFixture::getTheme(2)->getId(),
            SampleThemesFixture::getTheme(3)->getId(),
        ];

        $this->requestInterestingInPOST($profile->getId(), ['theme_ids' => $themeIds])
            ->execute()
            ->expectAuthError()
        ;

        $this->requestInterestingInPOST($profile->getId(), ['theme_ids' => $themeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->expectInterestingInIds($profile->getId(), $themeIds);

        $newThemeIds = [
            SampleThemesFixture::getTheme(5)->getId(),
            SampleThemesFixture::getTheme(1)->getId(),
            SampleThemesFixture::getTheme(4)->getId(),
        ];

        $this->requestInterestingInPOST($profile->getId(), ['theme_ids' => $newThemeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->expectInterestingInIds($profile->getId(), array_merge($themeIds, $newThemeIds));
    }

    public function testDeleteInterests() {
        $this->upFixture(
            new SampleThemesFixture()
        );

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $themeIds = [
            SampleThemesFixture::getTheme(1)->getId(),
            SampleThemesFixture::getTheme(2)->getId(),
            SampleThemesFixture::getTheme(3)->getId(),
        ];

        $this->requestInterestingInPOST($profile->getId(), ['theme_ids' => $themeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->expectInterestingInIds($profile->getId(), $themeIds);

        $deleteThemeIds = [
            SampleThemesFixture::getTheme(5)->getId(),
            SampleThemesFixture::getTheme(1)->getId(),
            SampleThemesFixture::getTheme(4)->getId(),
        ];

        $this->requestInterestingInDELETE($profile->getId(), $deleteThemeIds)
            ->auth($account->getAPIKey())
            ->execute()
            ->dump()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->expectInterestingInIds($profile->getId(), [
            SampleThemesFixture::getTheme(2)->getId(),
            SampleThemesFixture::getTheme(3)->getId(),
        ]);
    }

    private function expectInterestingInIds(int $profileId, array $ids) {
        $result = $this->requestGetProfile($profileId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
            ->getParsedLastResult()
        ;

        $compareIds = $result['entity']['interesting_in'];

        $this->assertEquals(sort($compareIds), sort($ids));
    }
}