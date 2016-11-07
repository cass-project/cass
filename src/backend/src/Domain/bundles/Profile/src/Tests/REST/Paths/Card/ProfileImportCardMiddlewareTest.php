<?php
namespace CASS\Domain\Bundles\Profile\Tests\REST\Paths\Card;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Entity\Card\Access\ProfileCardAccess;
use CASS\Domain\Bundles\Profile\Entity\Profile\Gender\Gender;
use CASS\Domain\Bundles\Profile\Tests\REST\Paths\ProfileMiddlewareTestCase;
use CASS\Util\GenerateRandomString;

/**
 * @backupGlobals disabled
 */
final class ProfileImportCardMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function test200()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();

        $card = [
            'access' => [
                'profile.first_name' => ProfileCardAccess::ACCESS_PUBLIC,
                'profile.last_name' => ProfileCardAccess::ACCESS_PUBLIC,
                'profile.middle_name' => ProfileCardAccess::ACCESS_PROTECTED,
                'profile.gender' => ProfileCardAccess::ACCESS_PROTECTED,
                'profile.interesting_in' => ProfileCardAccess::ACCESS_PROTECTED,
                'profile.expert_in' => ProfileCardAccess::ACCESS_PROTECTED,
                'profile.contacts.email' => ProfileCardAccess::ACCESS_PUBLIC,
                'profile.contacts.jabber' => ProfileCardAccess::ACCESS_PUBLIC,
                'profile.contacts.phone' => ProfileCardAccess::ACCESS_PRIVATE,
            ],
            'values' => [
                'profile.first_name' => GenerateRandomString::gen(8),
                'profile.last_name' => GenerateRandomString::gen(8),
                'profile.middle_name' => GenerateRandomString::gen(8),
                'profile.gender' => Gender::createFromStringCode('female')->getStringCode(),
                'profile.interesting_in' => [],
                'profile.expert_in' => [],
                'profile.contacts.jabber' => [
                    'user' => GenerateRandomString::gen(8),
                    'host' => 'jabber.ru'
                ],
                'profile.contacts.phone' => '7800900144'
            ],
        ];

        $requestJSON = ['card' => [
            'access' => array_map(function(string $key) use ($card) {
                return ['key' => $key, 'level' => $card['access'][$key]];
            }, array_keys($card['access'])),
            'values' => array_map(function(string $key) use ($card) {
                return ['key' => $key, 'value' => $card['values'][$key]];
            }, array_keys($card['values'])),
        ]];

        $this->requestImportCard($profile->getId(), $requestJSON)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'card' => $card,
            ]);

        $this->requestGetProfile($profile->getId())
            ->auth(DemoAccountFixture::getSecondAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'card' => [
                        'access' => $card['access'],
                        'values' => [
                            'profile.first_name' => $card['values']['profile.first_name'],
                            'profile.last_name' => $card['values']['profile.last_name'],
                            'profile.contacts.email' => $profile->getAccount()->getEmail(),
                        ],
                    ],
                    'profile' => [
                        'greetings' => [
                            'first_name' => $card['values']['profile.first_name'],
                            'last_name' => $card['values']['profile.last_name'],
                            'middle_name' => $card['values']['profile.middle_name'],
                        ],
                        'gender' => [
                            'string' => $card['values']['profile.gender'],
                        ],
                    ],
                ],
            ])
            ->expect(function(array $json) {
                $this->assertTrue(isset($json['entity']['card']['values']['profile.first_name']));
                $this->assertTrue(isset($json['entity']['card']['values']['profile.last_name']));
                $this->assertFalse(isset($json['entity']['card']['values']['profile.middle_name']));

                $this->assertTrue(isset($json['entity']['card']['values']['profile.contacts.jabber']));
                $this->assertFalse(isset($json['entity']['card']['values']['profile.contacts.phone']));
            })
        ;
    }

    public function test403()
    {

    }

    public function test404()
    {

    }
}