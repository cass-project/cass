<?php
namespace CASS\Domain\Collection\Tests\REST\Paths;

use CASS\Domain\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Collection\Collection\CollectionItem;
use CASS\Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Collection\Tests\REST\CollectionRESTTestCase;
use CASS\Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;

/**
 * @backupGlobals disabled
 */
final class DeleteCommunityCollectionTest extends CollectionRESTTestCase
{
    public function test200()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collectionToDelete = SampleCollectionsFixture::getCommunityCollection(1);
        $collectionId = $collectionToDelete->getId();
        list(, $communityId) = explode(':', $collectionToDelete->getOwnerSID());

        $this->requestGetCommunity($communityId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collectionIds = array_map(function(array $input) {
                    return $input['collection_id'];
                }, $jsonResponse['entity']['community']['collections']);

                $this->assertTrue(in_array($collectionId, $collectionIds));
            });

        $this->requestDeleteCollection($collectionToDelete->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

        $this->requestGetCommunity($communityId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collectionIds = array_map(function(array $input) {
                    return $input['collection_id'];
                }, $jsonResponse['entity']['community']['collections']);

                $this->assertFalse(in_array($collectionId, $collectionIds));
            });
    }

    public function test409()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $community = SampleCommunitiesFixture::getCommunity(1);
        $collectionId = array_map(function(CollectionItem $item) {
            return $item->getCollectionId();
        }, $community->getCollections()->getItems())[0];

        $this->requestDeleteCollection($collectionId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'error' => $this->expectString(),
                'success' => false
            ]);
    }
}