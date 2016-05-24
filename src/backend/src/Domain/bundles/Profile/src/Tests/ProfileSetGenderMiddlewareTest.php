<?php
namespace Domain\Profile\Tests;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileSetGenderMiddlewareTest extends ProfileMiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ];
    }

    public function testSetGender() {
        $profile = DemoProfileFixture::getProfile();

        $this->request('POST', sprintf('/protected/profile/%d/set-gender', $profile->getId()))
            ->setParameters(['gender' => 'fEmale'])
            ->execute()
            ->expectAuthError();

        $this->request('POST', sprintf('/protected/profile/%d/set-gender', $profile->getId()))
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->setParameters(['gender' => 'fEmale'])
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
        ;

        $this->requestGet($profile->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile->getId(),
                    'gender' => [
                        'int' => Profile::GENDER_FEMALE,
                        'string' => 'female'
                    ]
                ]
            ])
        ;

        $this->request('POST', sprintf('/protected/profile/%d/set-gender', $profile->getId()))
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->setParameters(['gender' => 'malE'])
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;


        $this->requestGet($profile->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile->getId(),
                    'gender' => [
                        'string' => 'male',
                        'int' => Profile::GENDER_MALE,
                    ]
                ]
            ])
        ;

    }

    public function testUnsetGender()
    {
        $profile = DemoProfileFixture::getProfile();

        $this->request('POST', sprintf('/protected/profile/%d/set-gender', $profile->getId()))
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->setParameters(['gender' => 'fEmale'])
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
        ;

        $this->requestGet($profile->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile->getId(),
                    'gender' => [
                        'int' => Profile::GENDER_FEMALE,
                        'string' => 'female'
                    ]
                ]
            ])
        ;

        $this->request('POST', sprintf('/protected/profile/%d/set-gender', $profile->getId()))
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->setParameters(['gender' => 'none'])
            ->execute()
            ->dump()
            ->expectStatusCode(200)
            ->expectJSONContentType()
        ;

        $this->requestGet($profile->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile->getId()
                ]
            ])
            ->expect(function(array $response) {
                $this->assertFalse(isset($response['entity']['gender']));
            });
        ;
    }

    private function requestGet(int $profileId) {
        return $this->request('GET', sprintf('/profile/%d/get', $profileId));
    }
}