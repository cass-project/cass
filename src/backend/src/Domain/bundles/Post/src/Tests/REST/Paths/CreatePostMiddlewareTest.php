<?php
namespace CASS\Domain\Bundles\Post\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Post\Entity\PostAttachmentOwner;
use CASS\Domain\Bundles\Post\PostType\Types\DefaultPostType;
use CASS\Domain\Bundles\Post\PostType\Types\DiscussionPostType;
use CASS\Domain\Bundles\Post\Tests\PostMiddlewareTest;
use Zend\Diactoros\UploadedFile;

/**
 * @backupGlobals disabled
 */
class CreatePostMiddlewareTest extends PostMiddlewareTest
{
    public function testPostCreate403()
    {
        $json = [
            'post_type' => DefaultPostType::CODE_INT,
            'profile_id' => 0,
            'collection_id' => 0,
            'title' => 'Demo title',
            'content' => 'Demo Post Content',
        ];

        $this->requestPostCreatePut($json)
            ->execute()
            ->expectAuthError();
    }

    public function testPostCreateProfile404()
    {
        $account = DemoAccountFixture::getAccount();

        $json = [
            "post_type" => DefaultPostType::CODE_INT,
            "profile_id" => 99999999,
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            'title' => 'Demo title',
            'content' => 'Demo Post Content',
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
            'title' => 'Demo title',
            'content' => 'Demo Post Content',
            "attachments" => [],
        ];

        $this->requestPostCreatePut($json)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testPostCreateDefaultType200()
    {
        $account = DemoAccountFixture::getAccount();

        $json = [
            "post_type" => DefaultPostType::CODE_INT,
            "profile_id" => $account->getCurrentProfile()->getId(),
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            'title' => 'Demo title',
            'content' => 'Demo Post Content',
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
                        'string' => DefaultPostType::CODE_STRING,
                    ],
                    'title' => [
                        'has' => true,
                        'value' => $json['title']
                    ],
                    'profile_id' => $json['profile_id'],
                    'collection_id' => $json['collection_id'],
                    'content' => $json['content'],
                    'attachments' => function($input) {
                        $this->assertTrue(is_array($input));
                        $this->assertEquals(0, count($input));
                    },
                ],
            ]);
    }

    public function testPostCreateDiscussionType200()
    {
        $account = DemoAccountFixture::getAccount();

        $json = [
            "post_type" => DiscussionPostType::CODE_INT,
            "profile_id" => $account->getCurrentProfile()->getId(),
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            'title' => 'Demo title',
            'content' => 'Demo Post Content',
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
                        'int' => DiscussionPostType::CODE_INT,
                        'string' => DiscussionPostType::CODE_STRING,
                    ],
                    'profile_id' => $json['profile_id'],
                    'collection_id' => $json['collection_id'],
                    'content' => $json['content'],
                    'attachments' => function($input) {
                        $this->assertTrue(is_array($input));
                        $this->assertEquals(0, count($input));
                    },
                ],
            ]);
    }

    public function testPostCreateWithFileAttachment200()
    {
        $account = DemoAccountFixture::getAccount();

        $localFileName = __DIR__ . '/Resources/grid-example.png';
        $uploadFile = new UploadedFile($localFileName, filesize($localFileName), 0);

        $attachmentId = $this->requestUploadAttachment($uploadFile)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                ],
            ])
            ->fetch(function($json) {
                return $json['entity']['id'];
            });

        $json = [
            "post_type" => DefaultPostType::CODE_INT,
            "profile_id" => $account->getCurrentProfile()->getId(),
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            "content" => "Demo Post Content",
            "attachments" => [
                $attachmentId,
            ],
        ];

        $request = $this->requestPostCreatePut($json)
            ->auth($account->getAPIKey())
            ->execute();

        $request
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'post_type' => [
                        'int' => DefaultPostType::CODE_INT,
                        'string' => DefaultPostType::CODE_STRING,
                    ],
                    'profile_id' => $json['profile_id'],
                    'collection_id' => $json['collection_id'],
                    'content' => $json['content'],
                    'attachments' => [
                        0 => [
                            'id' => $this->expectId(),
                            'sid' => $this->expectString(),
                            'date_created_on' => $this->expectString(),
                            'date_attached_on' => $this->expectString(),
                            'is_attached' => true,
                            'owner' => [
                                'id' => $request->fetch(function(array $json) {
                                    return $json['entity']['id'];
                                }),
                                'code' => PostAttachmentOwner::OWNER_CODE,
                            ],
                            'link' => [
                                'source' => [
                                    'source' => 'local',
                                    'public_path' => $this->expectString(),
                                    'storage_path' => $this->expectString(),
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }

    public function test200CreatePostWithTitle()
    {
        $account = DemoAccountFixture::getAccount();

        $json = [
            "post_type" => DefaultPostType::CODE_INT,
            "profile_id" => $account->getCurrentProfile()->getId(),
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            'content' => 'Demo Post Content',
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
                        'string' => DefaultPostType::CODE_STRING,
                    ],
                    'title' => [
                        'has' => false
                    ],
                    'profile_id' => $json['profile_id'],
                    'collection_id' => $json['collection_id'],
                    'content' => $json['content'],
                    'attachments' => function($input) {
                        $this->assertTrue(is_array($input));
                        $this->assertEquals(0, count($input));
                    },
                ],
            ])
            ->expect(function(array $json) {
                $this->assertFalse(isset($json['entity']['title']['value']));
            })
        ;
    }
}