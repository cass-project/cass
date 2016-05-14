<?php
namespace Domain\Profile\Tests;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileDeleteMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testDeleteProfile200() {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $result = $this->requestCreateProfile()
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId()
                ]
            ])
            ->getParsedLastResult()
        ;

        $newProfileId = $result['entity']['id'];

        $this->requestDeleteProfile($profile->getId())
            ->execute()
            ->expectAuthError()
        ;

        $this->requestDeleteProfile($profile->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'current_profile_id' => $newProfileId
            ])
        ;

        $this->requestGetProfile($newProfileId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'is_current' => true
                ]
            ]);
    }

    public function testAttemptRemoveLastProfile()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestDeleteProfile($profile->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
        ;
    }

    public function testRemoveCurrentProfile()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $result = $this->requestCreateProfile()
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
            ->getParsedLastResult()
        ;

        $newProfileId = $result['entity']['id'];

        $this->requestDeleteProfile($newProfileId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'current_profile_id' => $profile->getId()
            ])
        ;

        $this->requestGetProfile($profile->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'is_current' => true
                ]
            ]);
    }
}