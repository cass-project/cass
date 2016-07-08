<?php
namespace Domain\Post\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Post\Tests\Fixtures\SamplePostsFixture;
use Domain\Post\Tests\PostMiddlewareTest;

/**
 * @backupGlobals disabled
 */
class EditPostMiddlewareTest extends PostMiddlewareTest
{    
//    public function testPostEdit200() {
//        $this->upFixture(new SamplePostsFixture());
//    
//        $post = SamplePostsFixture::getPost(1);
//    
//        $json = [
//            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
//            "content" => "Demo Post Content",
//            "attachments" => [],
//        ];
//    
//        $this->requestPostEditPost($post->getId(), $json)
//            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
//            ->execute()
//            ->expectJSONContentType()
//            ->expectStatusCode(200)
//            ->expectJSONBody([
//                'success' => true
//            ]);
//    }
//
//    public function testPostEdit403()
//    {
//        $this->upFixture(new SamplePostsFixture());
//
//        $post = SamplePostsFixture::getPost(1);
//
//        $json = [
//            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
//            "content" => "Demo Post Content",
//            "attachments" => [],
//        ];
//
//        $this->requestPostEditPost($post->getId(), $json)
//            ->execute()
//            ->expectAuthError();
//    }
//
//    public function testPostEdit404()
//    {
//        $this->upFixture(new SamplePostsFixture());
//
//        $json = [
//            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
//            "content" => "Demo Post Content",
//            "attachments" => [],
//        ];
//
//        $this->requestPostEditPost(999999999, $json)
//            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
//            ->execute()
//            ->expectNotFoundError();
//    }
}