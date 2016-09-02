<?php
namespace CASS\Domain\Bundles\Collection\Tests\REST;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use CASS\Util\Definitions\Point;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Diactoros\UploadedFile;

abstract class CollectionRESTTestCase extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
        ];
    }

    protected function requestCreateCollection(array $json): RESTRequest
    {
        return $this->request('PUT', '/protected/collection/create')
            ->setParameters($json);
    }

    protected function requestGetCommunity(int $communityId): RESTRequest
    {
        return $this->request('GET', sprintf('/community/%d/get', $communityId));
    }

    protected function requestGetProfile(int $profileId): RESTRequest
    {
        return $this->request('GET', sprintf('/profile/%d/get', $profileId));
    }

    protected function requestDeleteCollection(int $collectionId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/collection/%d/delete', $collectionId));
    }

    protected function requestEditCollection(int $collectionId, array $json): RESTRequest
    {
        return $this->request('POST', sprintf('/protected/collection/%d/edit', $collectionId))
            ->setParameters($json);
    }

    protected function requestSetPublicOptions(int $collectionId, array $json): RESTRequest
    {
        return $this->request('POST', sprintf('/protected/collection/%d/set-public-options', $collectionId))
            ->setParameters($json);
    }

    protected function requestUploadImage(int $collectionId, Point $start, Point $end, string $localFile): RESTRequest
    {
        $uri = sprintf(
            '/protected/collection/%d/image-upload/crop-start/%d/%d/crop-end/%d/%d',
            $collectionId,
            $start->getX(),
            $start->getY(),
            $end->getX(),
            $end->getY()
        );

        $this->assertTrue(is_readable($localFile));

        return $this->request('POST', $uri)
            ->setUploadedFiles([
                'file' => new UploadedFile($localFile, filesize($localFile), 0)
            ]);
    }

    protected function requestDeleteImage(int $collectionId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/collection/%d/image-delete', $collectionId));
    }
}