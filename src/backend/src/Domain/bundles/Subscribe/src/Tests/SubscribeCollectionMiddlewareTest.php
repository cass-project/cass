<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;

/**
 * @backupGlobals disabled
 */
class SubscribeCollectionMiddlewareTest extends SubscribeMiddlewareTestCase
{

    public function testSubscribeCollection200()
    {
        $account = DemoAccountFixture::getAccount();
        $collections = SampleCollectionsFixture::getCommunityCollections();
        $collection = array_shift($collections);
        $this->requestSubscribeCollection($collection->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

    public function testSubscribeCollectionUnAuth403()
    {
        $collections = SampleCollectionsFixture::getCommunityCollections();
        $collection = array_shift($collections);
        $this->requestSubscribeCollection($collection->getId())
            ->execute()
            ->expectStatusCode(403)
            ;
    }

    public function testSubscribeCollectionNotFound404()
    {
        $account = DemoAccountFixture::getAccount();
        $this->requestSubscribeCollection(999999)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(404);
    }
}