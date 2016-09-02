<?php
namespace CASS\Domain\Bundles\Post\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Post\Tests\Fixtures\SamplePostsFixture;
use CASS\Domain\Bundles\Post\Tests\PostMiddlewareTest;

/**
 * @backupGlobals disabled
 */
class EditPostMiddlewareTest extends PostMiddlewareTest
{    
    public function testPostEdit200() {
        $this->upFixture(new SamplePostsFixture());

        $post = SamplePostsFixture::getPost(1);

        $json = [
            "content" => "* Demo Post Content",
        ];

        $this->requestPostEditPost($post->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true
            ]);
    }

    public function testPostEdit403()
    {
        $this->upFixture(new SamplePostsFixture());

        $post = SamplePostsFixture::getPost(1);

        $json = [
            "content" => "* Demo Post Content",
        ];

        $this->requestPostEditPost($post->getId(), $json)
            ->execute()
            ->expectAuthError();
    }

    public function testPostEdit404()
    {
        $this->upFixture(new SamplePostsFixture());

        $json = [
            "content" => "* Demo Post Content",
        ];

        $this->requestPostEditPost(999999999, $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }
}