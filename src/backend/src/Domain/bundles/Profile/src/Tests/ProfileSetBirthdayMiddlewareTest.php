<?php
namespace CASS\Domain\Bundles\Profile\Tests;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Entity\Profile;

/**
 * @backupGlobals disabled
 */
final class ProfileSetBirthdayMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testSetBirthday403NotAuthorized()
    {
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();
        $json = [
            'date' => $this->fromNow(-18)
        ];

        $this->requestSetBirthday($profile->getId(), $json)
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testSetBirthday404ProfileNotFound() {
        $date = $this->fromNow(-18);
        $json = [
            'date' => $date->format(\DateTime::RFC2822),
        ];

        $this->requestSetBirthday(self::NOT_FOUND_ID, $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testSetBirthday409TooYoung() {
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();
        $date = $this->fromNow(-1 * (Profile::MIN_AGE - 1));
        $json = [
            'date' => $date->format(\DateTime::RFC2822),
        ];

        $this->requestSetBirthday($profile->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(409)
            ->expectJSONBody([
                'success' => false,
                'error' => Profile::EXCEPTION_YOUNG
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

    public function testSetBirthday409TooOld() {
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();
        $date = $this->fromNow(-1 * (Profile::MAX_AGE + 1));
        $json = [
            'date' => $date->format(\DateTime::RFC2822),
        ];

        $this->requestSetBirthday($profile->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(409)
            ->expectJSONBody([
                'success' => false,
                'error' => Profile::EXCEPTION_OLD
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

    public function testSetBirthday409FromFuture() {
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();
        $date = $this->fromNow(+1);
        $json = [
            'date' => $date->format(\DateTime::RFC2822),
        ];

        $this->requestSetBirthday($profile->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(409)
            ->expectJSONBody([
                'success' => false,
                'error' => Profile::EXCEPTION_GUEST_FUTURE
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

    public function testSetBirthday409NotToday() {
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();
        $date = $this->fromNow(+0);
        $json = [
            'date' => $date->format(\DateTime::RFC2822),
        ];

        $this->requestSetBirthday($profile->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(409)
            ->expectJSONBody([
                'success' => false,
                'error' => Profile::EXCEPTION_YOUNG
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

    public function testSetBirthday200() {
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();
        $date = $this->fromNow(-1 * (Profile::MIN_AGE + 1));
        $json = [
            'date' => $date->format(\DateTime::RFC2822),
        ];

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
    }
}