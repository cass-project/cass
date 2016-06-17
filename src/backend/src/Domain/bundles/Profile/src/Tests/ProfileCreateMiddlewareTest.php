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
        $profile = DemoProfileFixture::getProfile();

        $this->requestCreateProfile()
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
          ->expect(function(array $result) {
              $collections = $result['entity']['collections'];
              $this->assertEquals(1, count($collections));
          });
        ;

        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile->getId(),
                    'is_current' => false
                ]
            ]);
    }

    public function testCreateProfile403()
    {
        $this->requestCreateProfile()
            ->execute()
            ->expectStatusCode(403)
            ->expectJSONContentType()
        ;
    }
}