<?php
namespace Domain\Post\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Post\PostType\Types\DefaultPostType;
use Domain\Post\Tests\PostMiddlewareTest;

/**
 * @backupGlobals disabled
 */
class CreatePostMiddlewareTest extends PostMiddlewareTest
{
    public function testPostCreate403() {
        $json = [
            'profile_id' => 0,
            'collection_id' => 0,
            'content' => 'Demo Post Content',
        ];

        $this->requestPostCreatePut($json)
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testPostCreateProfile404() {
        $account = DemoAccountFixture::getAccount();

        $json = [
            "post_type" => DefaultPostType::CODE_INT,
            "profile_id" => 99999999,
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            "content" => "string",
            "attachments" => [],
        ];

        return $this->requestPostCreatePut($json)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testPostCreateCollection404()
    {
        $account = DemoAccountFixture::getAccount();

        $json = [
            "post_type" => DefaultPostType::CODE_INT,
            "profile_id" => $account->getCurrentProfile()->getId(),
            "collection_id" => 999999999,
            "content" => "Demo Post Content",
            "attachments" => [],
        ];

        $this->requestPostCreatePut($json)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testPostCreate200() {
        $account = DemoAccountFixture::getAccount();

        $json = [
            "post_type" => DefaultPostType::CODE_INT,
            "profile_id" => $account->getCurrentProfile()->getId(),
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            "content" => "Demo Post Content",
            "attachments" => [],
        ];

        $this->requestPostCreatePut($json)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'post_type' => [
                        'int' => DefaultPostType::CODE_INT,
                        'string' => DefaultPostType::CODE_STRING
                    ],
                    'profile_id' => $json['profile_id'],
                    'collection_id' => $json['collection_id'],
                    'content' => $json['content'],
                    'attachments' => function($input) {
                        $this->assertTrue(is_array($input));
                        $this->assertEquals(0, count($input));
                    }
                ]
            ]);
    }
}