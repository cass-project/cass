<?php
namespace CASS\Domain\Bundles\Collection\Tests\REST\Paths;

use CASS\Util\Definitions\Point;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Collection\Tests\REST\CollectionRESTTestCase;

/**
 * @backupGlobals disabled
 */
final class ImageUploadCollectionTest extends CollectionRESTTestCase
{
    public function testUploadImage403()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $p1 = new Point(0, 0);
        $p2 = new Point(150, 150);
        $localFile = __DIR__ . '/Resources/grid-example.png';

        $this->requestUploadImage($collection->getId(), $p1, $p2, $localFile)
            ->execute()
            ->expectAuthError();
    }

    public function testUploadImage404()
    {
        $account = DemoAccountFixture::getAccount();

        $p1 = new Point(0, 0);
        $p2 = new Point(150, 150);
        $localFile = __DIR__ . '/Resources/grid-example.png';

        $this->requestUploadImage(9999, $p1, $p2, $localFile)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }


    public function testUploadImage422()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $p1 = new Point(0, 0);
        $p2 = new Point(5000, 5000);
        $localFile = __DIR__ . '/Resources/grid-example.png';

        $this->requestUploadImage($collection->getId(), $p1, $p2, $localFile)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(422)
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString()
            ]);
    }

    public function testUploadImage200()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $p1 = new Point(0, 0);
        $p2 = new Point(150, 150);
        $localFile = __DIR__ . '/Resources/grid-example.png';

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
    }
}