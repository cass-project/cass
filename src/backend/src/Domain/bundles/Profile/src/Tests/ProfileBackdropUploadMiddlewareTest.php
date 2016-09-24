<?php
namespace CASS\Domain\Bundles\Profile\Tests;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileBackdropUploadMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testBackdropUpload403()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $localFile = __DIR__ . '/Resources/grid500x500.png';

        $this->requestBackdropUpload($profile->getId(), $localFile, 'ffffff')
            ->execute()
            ->expectAuthError();
    }

    public function testBackdropUpload404()
    {
        $account = DemoAccountFixture::getAccount();

        $localFile = __DIR__ . '/Resources/grid500x500.png';

        $this->requestBackdropUpload(self::NOT_FOUND_ID, $localFile, 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testBackdropUpload200()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $localFile = __DIR__ . '/Resources/grid500x500.png';

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

        $backdropJSON = $this->requestBackdropUpload($profile->getId(), $localFile, 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'backdrop' => [
                    'type' => 'uploaded',
                    'metadata' => [
                        'public_path' => $this->expectString(),
                        'storage_path' => $this->expectString(),
                        'text_color' => 'ffffff'
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

    public function testBackdropUploadTestSizes()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestBackdropUpload($profile->getId(), __DIR__ . '/Resources/grid399x399.png', 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString(),
            ]);

        $this->requestBackdropUpload($profile->getId(), __DIR__ . '/Resources/grid500x500.png', 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'backdrop' => [
                    'type' => 'uploaded',
                    'metadata' => [
                        'public_path' => $this->expectString(),
                        'storage_path' => $this->expectString(),
                        'text_color' => 'ffffff'
                    ]
                ]
            ]);

        $this->requestBackdropUpload($profile->getId(), __DIR__ . '/Resources/grid400x400.png', 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'backdrop' => [
                    'type' => 'uploaded',
                    'metadata' => [
                        'public_path' => $this->expectString(),
                        'storage_path' => $this->expectString(),
                        'text_color' => 'ffffff'
                    ]
                ]
            ]);

        $this->requestBackdropUpload($profile->getId(), __DIR__ . '/Resources/grid2048x2048.png', 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'backdrop' => [
                    'type' => 'uploaded',
                    'metadata' => [
                        'public_path' => $this->expectString(),
                        'storage_path' => $this->expectString(),
                        'text_color' => 'ffffff'
                    ]
                ]
            ]);

        $this->requestBackdropUpload($profile->getId(), __DIR__ . '/Resources/grid2049x2049.png', 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString(),
            ]);
    }
}