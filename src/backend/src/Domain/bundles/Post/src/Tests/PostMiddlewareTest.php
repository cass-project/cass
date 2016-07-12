<?php
namespace Domain\Post\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Diactoros\UploadedFile;

/**
 * @backupGlobals disabled
 */
abstract class PostMiddlewareTest extends MiddlewareTestCase
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


    protected function requestUploadPostAttachment(UploadedFile $localFile):RESTRequest
    {
        return $this
            ->request('POST', '/protected/post-attachment/upload')
            ->setUploadedFiles([
                'file' => $localFile
            ]);
    }
}