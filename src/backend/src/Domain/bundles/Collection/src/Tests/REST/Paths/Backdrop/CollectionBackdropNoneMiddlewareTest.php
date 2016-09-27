<?php
namespace CASS\Domain\Bundles\Collection\Tests\REST\Paths\Backdrop;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Collection\Tests\REST\CollectionRESTTestCase;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
final class CollectionBackdropNoneMiddlewareTest extends CollectionRESTTestCase
{
    public function testNone403()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $this->requestBackdropNone($collection->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testNone404()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $this->requestBackdropNone(self::NOT_FOUND_ID)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testNone200()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $this->requestBackdropNone($collection->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'backdrop' => [
                    'type' => 'none'
                ]
            ]);

        $this->requestGetById($collection->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'backdrop' => [
                        'type' => 'none'
                    ]
                ]
            ]);
    }
}