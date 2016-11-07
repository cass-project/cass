<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;

/**
 * @backupGlobals disabled
 */
class SubscribeCommunityMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function test200()
    {
        $account = DemoAccountFixture::getAccount();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestSubscribeCommunity($community->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'profileId' => $account->getCurrentProfile()->getId(),
                    'subscribeId' => $community->getId(),
                    'subscribeType' => Subscribe::TYPE_COMMUNITY,
                ]
            ]);
    }

    public function test403()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestSubscribeCommunity($community->getId())
            ->execute()
            ->expectAuthError();
    }

    public function test404()
    {
        $account = DemoAccountFixture::getAccount();

        $this->requestSubscribeCommunity(self::NOT_FOUND_ID)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }
}