<?php
namespace CASS\Domain\Bundles\Profile\Tests;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Entity\Profile\Gender\GenderFemale;
use Domain\Profile\Entity\Profile\Greetings;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileEditPersonalMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testEditPersonal403()
    {
        $profile = DemoProfileFixture::getProfile();

        $json = [
            'method' => 'fl',
            'first_name' => 'Annie',
            'middle_name' => 'the Best',
            'last_name' => 'Mage',
            'nick_name' => 'annie_bears'
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
            'method' => 'fl',
            'first_name' => 'Annie',
            'middle_name' => 'the Best',
            'last_name' => 'Mage',
            'nick_name' => 'annie_bears'
        ];

        $this->requestEditPersonal($profile->getId(), $json)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'entity' => [
                    'id' => $profile->getId(),
                    'greetings' => [
                        'method' => $json['method'],
                        'greetings' => sprintf('%s % s', $json['first_name'], $json['last_name']),
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
            'method' => 'fl',
            'first_name' => 'Annie',
            'middle_name' => 'the Best',
            'last_name' => 'Mage',
            'nick_name' => 'annie_bears',
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
                        'method' => $json['greetings_method'],
                        'greetings' => sprintf('%s % s', $json['first_name'], $json['last_name']),
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