<?php
namespace Domain\Profile\Tests;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class ProfileExpertInMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testPutExpertIn()
    {
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

        $this->requestExpertInPUT($profile->getId(), ['theme_ids' => $themeIds])
            ->execute()
            ->expectAuthError();

        $this->requestExpertInPUT($profile->getId(), ['theme_ids' => $themeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

        $this->expectExpertInIds($profile->getId(), $themeIds);

        $newThemeIds = [
            SampleThemesFixture::getTheme(5)->getId(),
            SampleThemesFixture::getTheme(1)->getId(),
            SampleThemesFixture::getTheme(4)->getId(),
        ];

        $this->requestExpertInPUT($profile->getId(), ['theme_ids' => $newThemeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

        $this->expectExpertInIds($profile->getId(), $newThemeIds);
    }

    public function testPostExpertIn()
    {
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

        $this->requestExpertInPOST($profile->getId(), ['theme_ids' => $themeIds])
            ->execute()
            ->expectAuthError();

        $this->requestInterestingInPOST($profile->getId(), ['theme_ids' => $themeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

        $this->expectExpertInIds($profile->getId(), $themeIds);

        $newThemeIds = [
            SampleThemesFixture::getTheme(5)->getId(),
            SampleThemesFixture::getTheme(1)->getId(),
            SampleThemesFixture::getTheme(4)->getId(),
        ];

        $this->requestExpertInPOST($profile->getId(), ['theme_ids' => $newThemeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

        $this->expectExpertInIds($profile->getId(), array_merge($themeIds, $newThemeIds));
    }

    public function testDeleteExpertIn()
    {
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

        $this->requestExpertInPOST($profile->getId(), ['theme_ids' => $themeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

        $this->expectExpertInIds($profile->getId(), $themeIds);

        $deleteThemeIds = [
            SampleThemesFixture::getTheme(5)->getId(),
            SampleThemesFixture::getTheme(1)->getId(),
            SampleThemesFixture::getTheme(4)->getId(),
        ];

        $this->requestExpertInDELETE($profile->getId(), $deleteThemeIds)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

        $this->expectExpertInIds($profile->getId(), [
            SampleThemesFixture::getTheme(2)->getId(),
            SampleThemesFixture::getTheme(3)->getId(),
        ]);
    }

    private function expectExpertInIds(int $profileId, array $ids)
    {
        $result = $this->requestGetProfile($profileId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
            ->getParsedLastResult();

        $compareIds = $result['entity']['expert_in'];

        $this->assertEquals(sort($compareIds), sort($ids));
    }
}