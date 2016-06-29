<?php
namespace Domain\Post\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Post\Tests\Fixtures\SamplePostsFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class PostMiddlewareTest extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
            new SampleCollectionsFixture(),
        ];
    }

    public function testPostCreate200() {
        $account = DemoAccountFixture::getAccount();

        $json = [
            "profile_id" => $account->getCurrentProfile()->getId(),
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            "content" => "string",
            "attachments" => [],
        ];

        $this->requestPostCreatePut($json)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true
            ]);
    }

    public function testPostCreate403() {
        $json = [
            'profile_id' => 0,
            'collection_id' => 0,
            'content' => 'string',
        ];

        $this->requestPostCreatePut($json)
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testPostCreateProfile404() {
        $account = DemoAccountFixture::getAccount();

        $json = [
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
            "profile_id" => $account->getCurrentProfile()->getId(),
            "collection_id" => 999999999,
            "content" => "string",
            "attachments" => [],
        ];

        $this->requestPostCreatePut($json)
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testDeletePost200() {
        $this->upFixture(new SamplePostsFixture());

        $account = DemoAccountFixture::getAccount();

        $this->requestPostDelete(SamplePostsFixture::getPost(1)->getId())
            ->auth($account->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true
            ]);
    }

    public function testDeletePost403()
    {
        $this->upFixture(new SamplePostsFixture());

        $this->requestPostDelete(SamplePostsFixture::getPost(1)->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testDeletePost404() {

        $account = DemoAccountFixture::getAccount();

        $this->requestPostDelete(99999999)->auth($account->getAPIKey())->execute()
            ->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectJSONBody(['success' => FALSE]);
    }

    public function testPostEdit200()
    {
        $this->upFixture(new SamplePostsFixture());

        $post = SamplePostsFixture::getPost(1);

        $json = [
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            "content" => "string2",
            "attachments" => [],
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
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            "content" => "string2",
            "attachments" => [],
        ];

        $this->requestPostEditPost($post->getId(), $json)
            ->execute()
            ->expectAuthError();
    }

    public function testPostEdit404()
    {
        $this->upFixture(new SamplePostsFixture());

        $json = [
            "collection_id" => SampleCollectionsFixture::getProfileCollection(1)->getId(),
            "content" => "string2",
            "attachments" => [],
        ];

        $this->requestPostEditPost(999999999, $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testGetPost200()
    {
        $this->upFixture(new SamplePostsFixture());

        $post = SamplePostsFixture::getPost(1);
        $postId = $post->getId();


        return $this->requestPostGet($postId)
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true
            ])
            ->expect(function($result)use ($postId){
                $this->assertEquals($postId, $result['entity']['id']);

            });
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

    protected function requestPostCreatePut(array $json): RESTRequest {
        return $this->request('PUT', '/protected/post/create')->setParameters($json);
    }

    protected function requestPostDelete(int $postId): RESTRequest {
        return $this->request('DELETE', sprintf('/protected/post/%d/delete', $postId));
    }

    protected function requestPostEditPost(int $postId, array $json): RESTRequest {
        return $this->request('POST', sprintf('/protected/post/%d/edit', $postId))
            ->setParameters($json);
    }

    protected function requestPostGet(int $postId): RESTRequest {
        return $this->request('GET', sprintf('/post/%d/get', $postId));
    }
}