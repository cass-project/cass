<?php
namespace CASS\Domain\Bundles\Post\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Diactoros\UploadedFile;

/**
 * @backupGlobals disabled
 */
abstract class PostMiddlewareTest extends CASSMiddlewareTestCase
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


    protected function requestUploadAttachment(UploadedFile $localFile):RESTRequest
    {
        return $this
            ->request('POST', '/protected/attachment/upload')
            ->setUploadedFiles([
                'file' => $localFile
            ]);
    }
}