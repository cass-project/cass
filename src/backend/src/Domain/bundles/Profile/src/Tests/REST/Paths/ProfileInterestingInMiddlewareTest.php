<?php
namespace CASS\Domain\Bundles\Profile\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class ProfileInterestingInMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testPutInterests()
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

        $this->requestInterestingInPUT($profile->getId(), ['theme_ids' => $themeIds])
            ->execute()
            ->expectAuthError();

        $this->requestInterestingInPUT($profile->getId(), ['theme_ids' => $themeIds])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

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
            ]);

        $this->expectInterestingInIds($profile->getId(), $newThemeIds);
    }

    private function expectInterestingInIds(int $profileId, array $ids)
    {
        $result = $this->requestGetProfile($profileId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
            ->getParsedLastResult();

        $compareIds = $result['entity']['profile']['interesting_in_ids'];

        $this->assertEquals(sort($compareIds), sort($ids));
    }
}