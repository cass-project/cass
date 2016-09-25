<?php
namespace CASS\Domain\Bundles\Profile\Tests\REST\Paths\Backdrop;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Profile\Tests\REST\Paths\ProfileMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class ProfileBackdropPresetMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testPreset403()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestBackdropPreset($profile->getId(), "1")
            ->execute()
            ->expectAuthError();
    }

    public function testPreset404()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestBackdropPreset(self::NOT_FOUND_ID, "1")
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testPreset200()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'profile' => [
                        'backdrop' => [
                            'type' => 'none'
                        ]
                    ]
                ]
            ]);

        $backdropJSON = $this->requestBackdropPreset($profile->getId(), "1")
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

        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'profile' => [
                        'backdrop' => $backdropJSON
                    ]
                ]
            ]);
    }
}