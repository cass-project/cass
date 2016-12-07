<?php
namespace CASS\Domain\Bundles\Like\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Post\Tests\Fixtures\SamplePostsFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class LikePostMiddlewareTestCase extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array{
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
            new SampleCollectionsFixture(),
            new SamplePostsFixture()
        ];
    }

    public function requestLikePost(int $postId){
        return $this->request('PUT', sprintf('/like/post/%d/add-like', $postId));
    }

    public function requestDisLikePost(int $postId){
        return $this->request('PUT', sprintf('/like/post/%d/add-dislike', $postId));
    }

    public function requestRemovePostAttitude(int $postId){
        return $this->request('DELETE', sprintf('/like/post/%d/remove-attitude', $postId));
    }

}