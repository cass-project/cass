<?php
namespace Domain\Collection\Tests\REST\Paths;

use CASS\Util\Definitions\Point;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Collection\Tests\REST\CollectionRESTTestCase;

/**
 * @backupGlobals disabled
 */
final class ImageDeleteCollectionTest extends CollectionRESTTestCase
{
    public function testImageDelete()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $p1 = new Point(0, 0);
        $p2 = new Point(150, 150);
        $localFile = __DIR__ . '/Resources/grid-example.png';

        $this->requestUploadImage($collection->getId(), $p1, $p2, $localFile)
            ->execute()
            ->expectAuthError();

        $this->requestUploadImage($collection->getId(), $p1, $p2, $localFile)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'image' => $this->expectImageCollection()
            ])
            ->expectJSONBody([
                'image' => [
                    'is_auto_generated' => false
                ]
            ])
        ;

        $this->requestDeleteImage($collection->getId())
            ->execute()
            ->expectAuthError();

        $this->requestDeleteImage($collection->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'image' => $this->expectImageCollection()
            ])
            ->expectJSONBody([
                'image' => [
                    'is_auto_generated' => true
                ]
            ])
        ;
    }
}