<?php
namespace Domain\Collection\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Collection\Tests\REST\CollectionRESTTestCase;

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
}