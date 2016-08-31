<?php
namespace Domain\Community\Tests;

use CASS\Application\PHPUnit\RESTRequest\RESTRequest;
use CASS\Application\PHPUnit\TestCase\MiddlewareTestCase;
use CASS\Util\Definitions\Point;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Diactoros\UploadedFile;

abstract class CommunityMiddlewareTestCase extends MiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
        ];
    }

    protected function requestCreateCommunity(array $json): RESTRequest
    {
        return $this->request('PUT', '/protected/community/create')
            ->setParameters($json);
    }

    protected function requestEditCommunity(int $communityId, array $json)
    {
        return $this->request('POST', sprintf('/protected/community/%d/edit', $communityId))
            ->setParameters($json);
    }

    protected function requestUploadImage(int $communityId, Point $start, Point $end): RESTRequest
    {
        $uri = "/protected/community/{$communityId}/image-upload/crop-start/{$start->getX()}/{$start->getY()}/crop-end/{$end->getX()}/{$end->getY()}/";
        $fileName = __DIR__ . '/resources/grid-example.png';

        return $this->request('POST', $uri)
            ->setUploadedFiles([
                'file' => new UploadedFile($fileName, filesize($fileName), 0)
            ]);
    }

    protected function requestDeleteImage(int $communityId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/community/%d/image-delete', $communityId));
    }

    protected function requestGetCommunityById(int $communityId): RESTRequest
    {
        return $this->request('GET', sprintf('/community/%d/get', $communityId));
    }

    protected function requestGetCommunityBySID(string $communitySID): RESTRequest
    {
        return $this->request('GET', sprintf('/community/%s/get-by-sid', $communitySID));
    }

    protected function requestActivateFeature(int $communityId, string $feature): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/community/%d/feature/%s/activate', $communityId, $feature));
    }

    protected function requestDeactivateFeature(int $communityId, string $feature): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/community/%d/feature/%s/deactivate', $communityId, $feature));
    }

    protected function requestIsFeatureActivated(int $communityId, string $feature): RESTRequest
    {
        return $this->request('GET', sprintf('/protected/community/%d/feature/%s/is-activated', $communityId, $feature));
    }

    protected function requestSetPublicOptions(int $communityId, array $json): RESTRequest
    {
        return $this->request('POST', sprintf('/community/%d/set-public-options', $communityId))->setParameters($json);
    }

    protected function requestGetProfile(int $profileId): RESTRequest
    {
        return $this->request('GET', sprintf('/profile/%d/get', $profileId));
    }
}