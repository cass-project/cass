<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Collection;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikeCollectionMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class DisLikeCollectionTest extends LikeCollectionMiddlewareTestCase
{
    public function test200()
    {
        $this->requestDisLikeCollection(SampleCollectionsFixture::getCommunityCollection(1)->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 0,
                    'dislikes' => 1,
                ],
            ])
            ->expectStatusCode(200);
    }

    public function testUnAuth200()
    {
        $this->requestDisLikeCollection(SampleCollectionsFixture::getCommunityCollection(1)->getId())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 0,
                    'dislikes' => 1,
                ],
            ])
            ->expectStatusCode(200);
    }

    public function test403()
    {
        $this->requestDisLikeCollection(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

    public function test409()
    {
        $collectionId = SampleCollectionsFixture::getCommunityCollection(2)->getId();
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture());

        $this->requestDisLikeCollection($collectionId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409);
    }

}