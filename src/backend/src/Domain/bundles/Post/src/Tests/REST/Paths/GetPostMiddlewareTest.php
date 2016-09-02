<?php
namespace CASS\Domain\Bundles\Post\Tests\REST\Paths;

use CASS\Domain\Bundles\Post\Tests\Fixtures\SamplePostsFixture;
use CASS\Domain\Bundles\Post\Tests\PostMiddlewareTest;

/**
 * @backupGlobals disabled
 */
class GetPostMiddlewareTest extends PostMiddlewareTest
{
    public function testGetPost200()
    {
        $this->upFixture(new SamplePostsFixture());

        $post = SamplePostsFixture::getPost(1);

        return $this->requestPostGet($post->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true
            ]);
    }

    public function testGetPost404() {
        $this->upFixture(new SamplePostsFixture());

        return $this->requestPostGet(999999999)
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectJSONBody([
                'success' => false
            ]);
    }
}