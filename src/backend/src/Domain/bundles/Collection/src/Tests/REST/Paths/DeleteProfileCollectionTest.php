<?php
namespace Domain\Collection\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Collection\CollectionItem;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Collection\Tests\REST\CollectionRESTTestCase;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
final class DeleteProfileCollectionTest extends CollectionRESTTestCase
{
    public function test200()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collectionToDelete = SampleCollectionsFixture::getProfileCollection(1);
        $collectionId = $collectionToDelete->getId();
        list($owner, $profileId) = explode(':', $collectionToDelete->getOwnerSID());

        $this->requestGetProfile($profileId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collectionIds = array_map(function(array $input) {
                    return $input['collection_id'];
                }, $jsonResponse['entity']['profile']['collections']);

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

        $this->requestGetProfile($profileId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collectionIds = array_map(function(array $input) {
                    return $input['collection_id'];
                }, $jsonResponse['entity']['profile']['collections']);

                $this->assertFalse(in_array($collectionId, $collectionIds));
            });
    }

    public function test409()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $community = DemoProfileFixture::getProfile();
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