<?php
namespace Domain\Profile\Tests;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;

/**
 * @backupGlobals disabled
 */
class ProfileIsCurrentMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testProfileCurrent()
    {
        $account = DemoAccountFixture::getAccount();
        $profileIds = [];

        $this->requestCreateProfile()
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'is_current' => true
                ]
            ])
            ->with(function (array $json) use (&$profileIds) {
                $profileIds[] = $json['entity']['id'];
            });

        $this->requestCreateProfile()
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'is_current' => true
                ]
            ])
            ->with(function (array $json) use (&$profileIds) {
                $profileIds[] = $json['entity']['id'];
            });

        $this->requestCreateProfile()
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'is_current' => true
                ]
            ])
            ->with(function (array $json) use (&$profileIds) {
                $profileIds[] = $json['entity']['id'];
            });

        $this->assertEquals(3, count($profileIds));

        $this->requestGetProfile($profileIds[0])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'profile' => [
                    'id' => $this->expectId(),
                    'is_current' => false
                ]
            ]);

        $this->requestGetProfile($profileIds[1])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'profile' => [
                    'id' => $this->expectId(),
                    'is_current' => false
                ]
            ]);

        $this->requestGetProfile($profileIds[2])
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'profile' => [
                    'id' => $this->expectId(),
                    'is_current' => true
                ]
            ]);
    }
}