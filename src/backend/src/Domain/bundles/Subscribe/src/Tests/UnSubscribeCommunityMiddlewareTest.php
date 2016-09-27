<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
/**
 * @backupGlobals disabled
 */
class UnSubscribeCommunityMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testUnsubscribeCollectionSuccess200()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $account = DemoAccountFixture::getAccount();
        $this->requestUnSubscribeCommunity($community->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }
}