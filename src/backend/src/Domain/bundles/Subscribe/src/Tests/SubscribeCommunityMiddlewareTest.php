<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;

/**
 * @backupGlobals disabled
 */
class SubscribeCommunityMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testSubscribeCommunitySuccess200()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);
        
        $account = DemoAccountFixture::getAccount();
        $this->requestSubscribeCommunity($community->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

    public function testSubscribeCommunityNotAuth403()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);
        $this->requestSubscribeCommunity($community->getId())
            ->execute()
            ->expectStatusCode(403);
    }

    public function testSubscribeCommunityNotFound404()
    {
        $account = DemoAccountFixture::getAccount();
        $this->requestSubscribeCommunity(999999)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(404);
    }
}