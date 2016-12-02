<?php
namespace CASS\Domain\Bundles\Like\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class LikeCollectionMiddlewareTestCase extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array{
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
            new SampleCollectionsFixture()
        ];
    }

    public function requestLikeCollection(int $collectionId){
        return $this->request('PUT', sprintf('/like/collection/%d/add-like', $collectionId));
    }

    public function requestDisLikeCollection(int $collectionId){
        return $this->request('PUT', sprintf('/like/collection/%d/add-dislike', $collectionId));
    }

    public function requestRemoveCollectionAttitude(int $collectionId){
        return $this->request('DELETE', sprintf('/like/collection/%d/remove-attitude', $collectionId));
    }

}