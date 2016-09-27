<?php
namespace CASS\Domain\Bundles\Community\Tests\REST\Paths\Backdrop;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\CommunityMiddlewareTestCase;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
final class CommunityBackdropNoneMiddlewareTest extends CommunityMiddlewareTestCase
{
    public function testNone403()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestBackdropNone($community->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testNone404()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestBackdropNone(self::NOT_FOUND_ID)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testNone200()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestBackdropNone($community->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'backdrop' => [
                    'type' => 'none'
                ]
            ]);

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
    }
}