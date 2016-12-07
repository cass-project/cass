<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Post;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikePostMiddlewareTestCase;
use CASS\Domain\Bundles\Post\Tests\Fixtures\SamplePostsFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class LikePostTest extends LikePostMiddlewareTestCase
{
    public function test200()
    {

        $postId = SamplePostsFixture::getPost(1)->getId();
        $account = DemoProfileFixture::getProfile()->getAccount();

        $this->requestLikePost($postId)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 1,
                    'dislikes' => 0,
                    'attitude' => [
                        'state' => 'liked',
                        'likes' => 1,
                        'dislikes' => 0,
                    ],
                ],
            ])
            ->expectStatusCode(200);
    }

    public function testUnAuth200()
    {
        $this->requestLikePost(SamplePostsFixture::getPost(1)->getId())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 1,
                    'dislikes' => 0,
                    'attitude' => [
                        'state' => 'liked',
                        'likes' => 1,
                        'dislikes' => 0,
                    ],
                ],
            ])
            ->expectStatusCode(200);
    }

    public function test403()
    {
        $this->requestLikePost(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

    public function test409()
    {
        $collectionId = SamplePostsFixture::getPost(1)->getId();
        $this->upFixture(new DemoAttitudeFixture());

        $this->requestLikePost($collectionId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409);
    }
}