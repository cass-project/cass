<?php
namespace Domain\Profile\Tests;

use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileSwitchMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testSwitch()
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
                    'id' => $this->expectId()
                ]
            ])
            ->getParsedLastResult()
        ;

        $profile1Id = $profile->getId();
        $profile2Id = $result['entity']['id'];
        
        $this->requestSwitch($profile1Id)
            ->execute()
            ->expectAuthError();

        $this->requestSwitch($profile1Id)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile1Id,
                    'is_current' => true
                ]
            ])
        ;

        $this->requestGetProfile($profile1Id)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile1Id,
                    'is_current' => true
                ]
            ]);

        $this->requestGetProfile($profile2Id)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile2Id,
                    'is_current' => false
                ]
            ]);

        $this->requestSwitch($profile2Id)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile2Id,
                    'is_current' => true
                ]
            ])
        ;

        $this->requestGetProfile($profile1Id)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile1Id,
                    'is_current' => false
                ]
            ]);

        $this->requestGetProfile($profile2Id)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile2Id,
                    'is_current' => true
                ]
            ]);

    }

    public function testSwithSelf()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $profile1Id = $profile->getId();

        $this->requestSwitch($profile1Id)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile1Id,
                    'is_current' => true
                ]
            ])
        ;

        $this->requestGetProfile($profile1Id)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile1Id,
                    'is_current' => true
                ]
            ]);

    }
}