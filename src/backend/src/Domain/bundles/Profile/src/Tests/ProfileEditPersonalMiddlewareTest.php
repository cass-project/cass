<?php
namespace Domain\Profile\Tests;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Entity\Profile\Gender\GenderFemale;
use Domain\Profile\Entity\Profile\Greetings;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileEditPersonalMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testEditPersonal403()
    {
        $profile = DemoProfileFixture::getProfile();

        $json = [
            'greetings_method' => 'fl',
            'first_name' => 'Annie',
            'middle_name' => 'the Best',
            'last_name' => 'Mage',
            'nickname' => 'annie_bears'
        ];

        $this->requestEditPersonal($profile->getId(), $json)
            ->execute()
            ->expectAuthError();
    }

    public function testEditPersonal()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $json = [
            'greetings_method' => 'fl',
            'first_name' => 'Annie',
            'middle_name' => 'the Best',
            'last_name' => 'Mage',
            'nickname' => 'annie_bears'
        ];

        $this->requestEditPersonal($profile->getId(), $json)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'entity' => [
                    'id' => $profile->getId(),
                    'greetings' => [
                        'greetings_method' => $json['greetings_method'],
                        'first_name' => $json['first_name'],
                        'last_name' => $json['last_name'],
                        'middle_name' => $json['middle_name'],
                    ]
                ]
            ]);
    }

    public function editPersonalWithGender()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $json = [
            'greetings_method' => 'fl',
            'first_name' => 'Annie',
            'middle_name' => 'the Best',
            'last_name' => 'Mage',
            'nickname' => 'annie_bears',
            'gender' => 'female'
        ];

        $this->requestEditPersonal($profile->getId(), $json)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'entity' => [
                    'id' => $profile->getId(),
                    'greetings' => [
                        'greetings_method' => $json['greetings_method'],
                        'first_name' => $json['first_name'],
                        'last_name' => $json['last_name'],
                        'middle_name' => $json['middle_name'],
                    ],
                    'gender' => [
                        'int' => GenderFemale::INT_CODE,
                        'string' => GenderFemale::STRING_CODE
                    ]
                ]
            ]);
    }
}