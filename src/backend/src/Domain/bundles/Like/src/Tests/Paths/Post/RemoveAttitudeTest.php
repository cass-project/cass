<?php

namespace CASS\Domain\Bundles\Like\Tests\Paths\Post;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Like\Tests\Fixtures\DemoAttitudeFixture;
use CASS\Domain\Bundles\Like\Tests\LikePostMiddlewareTestCase;
use CASS\Domain\Bundles\Post\Tests\Fixtures\SamplePostsFixture;

/**
 * @backupGlobals disabled
 */
class RemoveAttitudeTest extends LikePostMiddlewareTestCase
{
    public function test200()
    {
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture());
        $postId = SamplePostsFixture::getPost(1)->getId();

        $this->requestRemovePostAttitude($postId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'attitude' => [
                        'state' => 'none',
                    ],
                ],
            ])
            ->expectStatusCode(200);
    }

    public function test404()
    {
        $this->upFixture($demoAttitudes = new DemoAttitudeFixture());

        $this->requestRemovePostAttitude(self::NOT_FOUND_ID)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }
}