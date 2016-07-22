<?php
namespace Domain\Profile\Tests;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileGetMiddlewareTest extends ProfileMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ];
    }

    public function testGetProfile200()
    {
        $profile = DemoProfileFixture::getProfile();

        $this->requestGetProfile($profile->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'profile' => [
                        'id' => $profile->getId(),
                        'collections' => [
                            0 => [
                                'collection_id' => $this->expectId(),
                                'position' => 1,
                            ]
                        ]
                    ],
                    'collections' => [
                        0 => [
                            'id' => $this->expectId(),
                            'sid' => $this->expectString(),
                            'owner_sid' => $this->expectString(),
                            'owner' => [
                                'id' => $this->expectString(),
                                'type' => 'profile'
                            ],
                            'title' => $this->expectString(),
                            'description' => $this->expectString()
                        ]
                    ]
                ]
            ]);;
    }

    public function testGetProfile404()
    {
        $this->requestGetProfile(99999)
            ->execute()
            ->expectStatusCode(404)
            ->expectJSONContentType();
    }
}