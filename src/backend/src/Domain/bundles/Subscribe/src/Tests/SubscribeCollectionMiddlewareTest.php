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
            ->dump()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

}