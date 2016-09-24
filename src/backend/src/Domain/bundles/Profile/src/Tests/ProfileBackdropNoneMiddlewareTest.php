<?php
namespace CASS\Domain\Bundles\Profile\Tests;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileBackdropNoneMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testNone403()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestBackdropNone($profile->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testNone404()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestBackdropNone(self::NOT_FOUND_ID)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testNone200()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestBackdropNone($profile->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'backdrop' => [
                    'type' => 'none'
                ]
            ]);

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
    }
}