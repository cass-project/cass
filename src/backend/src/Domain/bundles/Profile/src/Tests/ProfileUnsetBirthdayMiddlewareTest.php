<?php
namespace CASS\Domain\Profile\Tests;

use CASS\Domain\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Profile\Entity\Profile;

/**
 * @backupGlobals disabled
 */
final class ProfileUnsetBirthdayMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testUnsetBirthday403NotAuthorized()
    {
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();

        $this->requestUnsetBirthday($profile->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testUnsetBirthday404ProfileNotFound()
    {
        $this->requestUnsetBirthday(self::NOT_FOUND_ID)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testUnsetBirthday200HasNoBirthday()
    {
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();

        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'profile' => [
                        'birthday' => $this->expectUndefined()
                    ]
                ]
            ]);

        $this->requestUnsetBirthday($profile->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'profile' => [
                        'birthday' => $this->expectUndefined()
                    ]
                ]
            ]);
    }

    public function testUnsetBirthday200HasBirthday()
    {
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();
        $date = $this->fromNow(-1 * (Profile::MIN_AGE + 1));
        $json = [
            'date' => $date->format(\DateTime::RFC2822),
        ];

        $this->requestSetBirthday($profile->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
            ]);


        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'profile' => [
                        'birthday' => $date->format(\DateTime::RFC2822)
                    ]
                ]
            ]);

        $this->requestUnsetBirthday($profile->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);


        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'profile' => [
                        'birthday' => $this->expectUndefined()
                    ]
                ]
            ]);
    }
}