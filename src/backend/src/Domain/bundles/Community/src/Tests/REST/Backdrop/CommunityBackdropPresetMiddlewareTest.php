<?php
namespace CASS\Domain\Bundles\Community\Tests\REST\Paths\Backdrop;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\CommunityMiddlewareTestCase;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
final class CommunityBackdropPresetMiddlewareTest extends CommunityMiddlewareTestCase
{
    public function testPreset403()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestBackdropPreset($community->getId(), "1")
            ->execute()
            ->expectAuthError();
    }

    public function testPreset404()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestBackdropPreset(self::NOT_FOUND_ID, "1")
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testPreset200()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestGetCommunityById($community->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'community' => [
                        'backdrop' => [
                            'type' => 'none'
                        ]
                    ]
                ]
            ]);

        $backdropJSON = $this->requestBackdropPreset($community->getId(), "1")
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'backdrop' => [
                    'type' => 'preset',
                    'metadata' => [
                        'preset_id' => '1',
                        'public_path' => $this->expectString(),
                        'storage_path' => $this->expectString(),
                        'text_color' => '#ffffff',
                    ]
                ]
            ])
            ->fetch(function(array $json) {
                return $json['backdrop'];
            })
        ;

        $this->requestGetCommunityById($community->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'community' => [
                        'backdrop' => $backdropJSON
                    ]
                ]
            ]);
    }
}