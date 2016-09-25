<?php
namespace CASS\Domain\Bundles\Profile\Tests\REST\Paths\Backdrop;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Profile\Tests\REST\Paths\ProfileMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class ProfileBackdropColorMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testColor403()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestBackdropColor($profile->getId(), 'red')
            ->execute()
            ->expectAuthError();
    }

    public function testColor404()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestBackdropColor(self::NOT_FOUND_ID, 'red')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testColor200()
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

        $backdropJSON = $this->requestBackdropColor($profile->getId(), 'red')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'backdrop' => [
                    'type' => 'color',
                    'metadata' => [
                        'palette' => [
                            'code' => 'red',
                            'background' => [
                                'code' => 'red.500',
                                'hexCode' => $this->expectString(),
                            ],
                            'foreground' => [
                                'code' => 'red.50',
                                'hexCode' => $this->expectString(),
                            ],
                            'border' => [
                                'code' => 'red.900',
                                'hexCode' => $this->expectString(),
                            ]
                        ]
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