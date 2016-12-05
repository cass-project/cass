<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Collection;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikeCollectionMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class RemoveAttitudeCollectionTest extends LikeCollectionMiddlewareTestCase
{
    public function test200()
    {
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture()); 
        $collectionId = SampleCollectionsFixture::getCommunityCollection(1)->getId();

        $this->requestRemoveCollectionAttitude($collectionId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true
            ])
            ->expectStatusCode(200)
        ;
    }

    public function test404()
    {
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture());

        $this->requestRemoveCollectionAttitude(self::NOT_FOUND_ID)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError()
        ;
    }
}