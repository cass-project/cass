<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;

/**
 * @backupGlobals disabled
 */
class UnSubscribeCollectionMiddlewareTest extends SubscribeMiddlewareTestCase
{
    public function testUnSubscribeCollectionSuccess200()
    {
        $account = DemoAccountFixture::getAccount();

        $collections = SampleCollectionsFixture::getCommunityCollections();
        /** @var Collection $collection */
        $collection = array_shift($collections);

        $this->requestUnSubscribeCollection($collection->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

    public function testUnSubscribeCollectionUnAuth403()
    {
        $collections = SampleCollectionsFixture::getCommunityCollections();
        /** @var Collection $collection */
        $collection = array_shift($collections);

        $this->requestUnSubscribeCollection($collection->getId())
            ->execute()
            ->expectStatusCode(403);
    }

    public function testUnSubscribeCollectionNotFound404()
    {
        $account = DemoAccountFixture::getAccount();

        $this->requestUnSubscribeCollection(9999999)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(404);
    }
}