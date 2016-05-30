<?php


namespace Domain\Post\Tests;


use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Entity\Collection;
use Domain\Post\Entity\Post;
use Domain\Post\Tests\Fixtures\DemoCollectionFixture;
use Domain\Post\Tests\Fixtures\DemoCommunityFixture;
use Domain\Post\Tests\Fixtures\DemoPostFixture;
use Domain\Post\Tests\Fixtures\DemoThemeFixtures;

/**
 * @backupGlobals disabled
 */
class PostMiddlewareTest extends MiddlewareTestCase
{
  protected function getFixtures(): array{
   return [
     new DemoAccountFixture(),
     new DemoThemeFixtures(),
     new DemoCommunityFixture(),
     new DemoCollectionFixture(),
     new DemoPostFixture()
   ];
  }

  public function testPostCreate200()
  {
    $account = DemoAccountFixture::getAccount();

    $json = [
      "profile_id"    => $account->getCurrentProfile()->getId(),
      "collection_id" => DemoCollectionFixture::getCollection()->getId(),
      "content"       => "string",
      "attachments"   => [],
    ];

    return $this->requestPostCreatePut($json)->auth($account->getAPIKey())->execute()
      ->dump()
      ->expectJSONContentType()
      ->expectStatusCode(200)
      ->expectJSONBody(['success' => TRUE])
     ;
  }

  public function testPostCreate403()
  {
    $json = [
      'profile_id'    => 0,
      'collection_id' => 0,
      'content'       => 'string',
    ];

    return $this->requestPostCreatePut($json)->execute()->expectAuthError();
  }

  public function testPostCreateProfile404()
  {
    $account = DemoAccountFixture::getAccount();
    $json = [
      "profile_id"    => 23111,
      "collection_id" => DemoCollectionFixture::getCollection()->getId(),
      "content"       => "string",
      "attachments"   => [],
    ];

    return $this->requestPostCreatePut($json)->auth($account->getAPIKey())->execute()
      ->dump()
                ->expectJSONContentType()
                ->expectStatusCode(404)
                ->expectJSONBody(['success' => FALSE])
      ;
  }

  public function testPostCreateCollection404()
  {
    $account = DemoAccountFixture::getAccount();

    $json = [
      "profile_id"    => $account->getCurrentProfile()->getId(),
      "collection_id" => 999999999,
      "content"       => "string",
      "attachments"   => [],
    ];

    return $this->requestPostCreatePut($json)->auth($account->getAPIKey())->execute()
                ->expectJSONContentType()
                ->expectStatusCode(404)
                ->expectJSONBody(['success' => FALSE])
      ;
  }

  public function testDeletePost200()
  {
    /** @var Post $post */
    $post = DemoPostFixture::getPost();

    $account = DemoAccountFixture::getAccount();
    return $this->requestPostDelete($post->getId())->auth($account->getAPIKey())->execute()
      ->expectJSONContentType()
      ->expectStatusCode(200)
      ->expectJSONBody(['success' => TRUE]);
  }

  public function testDeletePost403()
  {
    return $this->requestPostDelete(21)->execute()
                ->expectAuthError();
  }

  public function testDeletePost404()
  {

    $account = DemoAccountFixture::getAccount();
    return $this->requestPostDelete(99999999)->auth($account->getAPIKey())->execute()
      ->expectJSONContentType()
                ->expectStatusCode(404)
                ->expectJSONBody(['success' => FALSE]);
  }

  public function testPostEdit200()
  {
    /** @var Post $account */
    $account = DemoAccountFixture::getAccount();
    /** @var Post $post */
    $post = DemoPostFixture::getPost();
    /** @var Collection $collection */
    $collection = DemoCollectionFixture::getCollection();

    $json = [
      "collection_id" => $collection->getId(),
      "content"       => "string2",
      "attachments"   => [],
    ];

    $this->requestPostEditPost($post->getId(),$json)->auth($account->getAPIKey())->execute()
      ->expectJSONContentType()
      ->expectStatusCode(200)
      ->expectJSONBody(['success' => TRUE]);
  }
  public function testPostEdit403()
  {
    $this->requestPostEditPost(3213,[])->execute()->expectAuthError();
  }

  public function testPostEdit404()
  {
    /** @var Post $account */
    $account = DemoAccountFixture::getAccount();

    /** @var Collection $collection */
    $collection = DemoCollectionFixture::getCollection();

    $json = [
      "collection_id" => $collection->getId(),
      "content"       => "string2",
      "attachments"   => [],
    ];

    $this->requestPostEditPost(999999999,$json)->auth($account->getAPIKey())->execute()
         ->expectJSONContentType()
         ->expectStatusCode(404)
         ->expectJSONBody(['success' => FALSE]);
  }

  public function testGetPost200()
  {
    /** @var Post $post */
    $post = DemoPostFixture::getPost();

    return $this->requestPostGet($post->getId())->execute()
                ->expectJSONContentType()
                ->expectStatusCode(200)
                ->expectJSONBody(['success' => TRUE]);
  }

  public function testGetPost404()
  {
    return $this->requestPostGet(9898989898)->execute()
                ->expectJSONContentType()
                ->expectStatusCode(404)
                ->expectJSONBody(['success' => FALSE]);
  }

  protected function requestPostCreatePut(array $json): RESTRequest
  {
    return $this->request('PUT', '/protected/post/create')->setParameters($json);
  }

  protected function requestPostDelete(int $postId): RESTRequest
  {
    return $this->request('DELETE', sprintf('/protected/post/%d/delete', $postId));
  }

  protected function requestPostEditPost(int $postId, array $json): RESTRequest
  {
    return $this->request('POST', sprintf('/protected/post/%d/edit', $postId))
      ->setParameters($json);
  }

  protected function requestPostGet(int $postId): RESTRequest
  {
    return $this->request('GET', sprintf('/post/%d/get', $postId));
  }

}