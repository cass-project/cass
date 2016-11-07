<?php
namespace CASS\Domain\Bundles\Profile\Tests\REST\Paths\Card;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Entity\Card\Access\ProfileCardAccess;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Profile\Tests\REST\Paths\ProfileMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
final class ProfileExportCardMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function test404()
    {
        $this->requestExportCard(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

    public function test200Private()
    {
        $sourceAccount = DemoAccountFixture::getAccount();
        $targetAccount = DemoAccountFixture::getSecondAccount();

        $profile = $sourceAccount->getCurrentProfile();

        $this->requestExportCard($profile->getId())
            ->auth($targetAccount->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'card' => [
                    'access' => [
                        'profile.first_name' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.last_name' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.middle_name' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.gender' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.interesting_in' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.expert_in' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.contacts.email' => ProfileCardAccess::ACCESS_PRIVATE,
                    ],
                    'values' => [
                        'profile.first_name' => $profile->getGreetings()->getFirstName(),
                        'profile.last_name' => $profile->getGreetings()->getLastName(),
                        'profile.middle_name' => $profile->getGreetings()->getMiddleName(),
                        'profile.gender' => $profile->getGender()->getStringCode(),
                        'profile.interesting_in' => $profile->getInterestingInIds(),
                        'profile.expert_in' => $profile->getExpertInIds(),
                    ],
                ]
            ])
            ->expect(function(array $json) {
                $this->assertFalse(isset($json['card']['values']['profile.contacts.email']));
            });
    }

    public function test200()
    {
        $profile = DemoProfileFixture::getProfile();

        $this->requestExportCard($profile->getId())
            ->auth($profile->getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'card' => [
                    'access' => [
                        'profile.first_name' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.last_name' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.middle_name' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.gender' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.interesting_in' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.expert_in' => ProfileCardAccess::ACCESS_PUBLIC,
                        'profile.contacts.email' => ProfileCardAccess::ACCESS_PRIVATE,
                    ],
                    'values' => [
                        'profile.first_name' => $profile->getGreetings()->getFirstName(),
                        'profile.last_name' => $profile->getGreetings()->getLastName(),
                        'profile.middle_name' => $profile->getGreetings()->getMiddleName(),
                        'profile.gender' => $profile->getGender()->getStringCode(),
                        'profile.interesting_in' => $profile->getInterestingInIds(),
                        'profile.expert_in' => $profile->getExpertInIds(),
                        'profile.contacts.email' => $profile->getAccount()->getEmail(),
                    ],
                ]
            ]);
    }
}