<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Collection;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikeCollectionMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class LikeCollectionTest extends LikeCollectionMiddlewareTestCase
{
    public function test200()
    {
        $this->requestLikeCollection(SampleCollectionsFixture::getCommunityCollection(1)->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 1,
                    'dislikes' => 0,
                ],
            ])
            ->expectStatusCode(200);
    }

    public function testUnAuth200()
    {
        $this->requestLikeCollection(SampleCollectionsFixture::getCommunityCollection(1)->getId())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 1,
                    'dislikes' => 0,
                ],
            ])
            ->expectStatusCode(200);
    }

    public function test403()
    {
        $this->requestLikeCollection(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

    public function test409()
    {
        $collectionId = SampleCollectionsFixture::getCommunityCollection(1)->getId();
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture());

        $this->requestLikeCollection($collectionId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409);
    }

}