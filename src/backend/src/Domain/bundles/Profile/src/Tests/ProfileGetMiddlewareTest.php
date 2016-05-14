<?php
namespace Domain\Profile\Tests;

use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileGetMiddlewareTest extends ProfileMiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ];
    }

    public function testGetProfile200() {
        $profile = DemoProfileFixture::getProfile();

        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $profile->getId()
                ]
            ]);
        ;
    }

    public function testGetProfile404() {
        $this->requestGetProfile(99999)
            ->execute()
            ->expectStatusCode(404)
            ->expectJSONContentType()
        ;
    }
}