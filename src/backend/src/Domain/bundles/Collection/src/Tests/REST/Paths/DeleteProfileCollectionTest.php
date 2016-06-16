<?php
namespace Domain\Collection\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Collection\Tests\REST\CollectionRESTTestCase;

/**
 * @backupGlobals disabled
 */
final class DeleteProfileCollectionTest extends CollectionRESTTestCase
{
    public function test200() {
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
                }, $jsonResponse['entity']['collections']);

                $this->assertTrue(in_array($collectionId, $collectionIds));
            })
        ;

        $this->requestDeleteCollection($collectionToDelete->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->requestGetProfile($profileId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collectionIds = array_map(function(array $input) {
                    return $input['collection_id'];
                }, $jsonResponse['entity']['collections']);

                $this->assertFalse(in_array($collectionId, $collectionIds));
            })
        ;
    }
}