<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Paths;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Tests\Fixtures\DemoSubscribeFixture;
use CASS\Domain\Bundles\Subscribe\Tests\SubscribeMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class SubscribeCollectionMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function test200()
    {
        $account = DemoAccountFixture::getAccount();
        $collections = SampleCollectionsFixture::getCommunityCollections();
        $collection = array_shift($collections); /** @var Collection $collection */

        $this->requestSubscribeCollection($collection->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'subscribe' => [
                    'profile_id' => $account->getCurrentProfile()->getId(),
                    'subscribe_id' => $collection->getId(),
                    'subscribe_type' => Subscribe::TYPE_COLLECTION,
                    'entity' => [
                        'id' => $collection->getId(),
                    ],
                ]
            ]);
    }

    public function test403()
    {
        $collections = SampleCollectionsFixture::getCommunityCollections();
        $collection = array_shift($collections);

        $this->requestSubscribeCollection($collection->getId())
            ->execute()
            ->expectAuthError();
    }

    public function test404()
    {
        $account = DemoAccountFixture::getAccount();

        $this->requestSubscribeCollection(self::NOT_FOUND_ID)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function test409()
    {
        $this->upFixture( $fixture = new DemoSubscribeFixture() );
        $account = DemoAccountFixture::getAccount();
        $subscribedCollection = $fixture->getSubscribe('collection', 1);
        $this->requestSubscribeCollection($subscribedCollection->getSubscribeId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
            ]);
    }

    
}