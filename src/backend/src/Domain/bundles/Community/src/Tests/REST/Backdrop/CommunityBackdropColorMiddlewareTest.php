<?php
namespace CASS\Domain\Bundles\Community\Tests\REST\Paths\Backdrop;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\CommunityMiddlewareTestCase;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
final class CommunityBackdropColorMiddlewareTest extends CommunityMiddlewareTestCase
{
    public function testColor403()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestBackdropColor($community->getId(), 'red')
            ->execute()
            ->expectAuthError();
    }

    public function testColor404()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestBackdropColor(self::NOT_FOUND_ID, 'red')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testColor200()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestGetCommunityById($community->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'community' => [
                        'backdrop' => [
                            'type' => 'none'
                        ]
                    ]
                ]
            ]);

        $backdropJSON = $this->requestBackdropColor($community->getId(), 'red')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'backdrop' => [
                    'type' => 'color',
                    'metadata' => [
                        'palette' => [
                            'code' => 'red',
                            'background' => [
                                'code' => 'red.500',
                                'hexCode' => $this->expectString(),
                            ],
                            'foreground' => [
                                'code' => 'red.50',
                                'hexCode' => $this->expectString(),
                            ],
                            'border' => [
                                'code' => 'red.900',
                                'hexCode' => $this->expectString(),
                            ]
                        ]
                    ]
                ]
            ])
            ->fetch(function(array $json) {
                return $json['backdrop'];
            })
        ;

        $this->requestGetCommunityById($community->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'community' => [
                        'backdrop' => $backdropJSON
                    ]
                ]
            ]);
    }
}