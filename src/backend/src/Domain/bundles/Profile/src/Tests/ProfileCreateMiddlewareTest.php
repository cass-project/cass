<?php
namespace Domain\Profile\Tests;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileCreateMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testCreateProfile()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoAccountFixture::getAccount()->getCurrentProfile();

        $this->requestCreateProfile()
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'sid' => $this->expectString(),
                    'is_current' => true,
                    'image' => $this->expectImageCollection()
                ]
            ])
            ->expect(function (array $result) {
                $collections = $result['entity']['collections'];
                $this->assertEquals(1, count($collections));
            });;

        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'profile' => [
                        'id' => $profile->getId(),
                        'sid' => $this->expectString(),
                        'is_current' => false,
                        'image' => $this->expectImageCollection()
                    ]
                ]
            ])
            ->expectJSONBody([
                'entity' => [
                    'profile' => [
                        'image' => [
                            'is_auto_generated' => true
                        ]
                    ]
                ]
            ])
        ;
    }

    public function testCreateProfile403()
    {
        $this->requestCreateProfile()
            ->execute()
            ->expectStatusCode(403)
            ->expectJSONContentType();
    }
}