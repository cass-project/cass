<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Collection;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikePostMiddlewareTestCase;
use CASS\Domain\Bundles\Post\Tests\Fixtures\SamplePostsFixture;

/**
 * @backupGlobals disabled
 */
class DisLikePostTest extends LikePostMiddlewareTestCase
{
    public function test200()
    {
        $this->requestDisLikePost(SamplePostsFixture::getPost(1)->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 0,
                    'dislikes' => 1,
                    'attitude' =>[
                        'state' => 'disliked',
                        'likes' => 0,
                        'dislikes' => 1,
                    ]
                ],
            ])
            ->expectStatusCode(200);
    }

    public function testUnAuth200()
    {
        $this->requestDisLikePost(SamplePostsFixture::getPost(1)->getId())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'likes' => 0,
                    'dislikes' => 1,
                    'attitude' =>[
                        'state' => 'disliked',
                        'likes' => 0,
                        'dislikes' => 1,
                    ]
                ],
            ])
            ->expectStatusCode(200);
    }

    public function test403()
    {
        $this->requestDisLikePost(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

    public function test409()
    {
        $this->upFixture( new DemoAttitudeFixture());

        $this->requestDisLikePost(SamplePostsFixture::getPost(2)->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409);
    }

}