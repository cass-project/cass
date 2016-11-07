<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Paths;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
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
                'entity' => [
                    'profileId' => $account->getCurrentProfile()->getId(),
                    'subscribeId' => $collection->getId(),
                    'subscribeType' => Subscribe::TYPE_COLLECTION,
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
}