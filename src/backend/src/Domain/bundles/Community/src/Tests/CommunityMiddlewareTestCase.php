<?php
namespace CASS\Domain\Bundles\Community\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use CASS\Util\Definitions\Point;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Diactoros\UploadedFile;

abstract class CommunityMiddlewareTestCase extends CASSMiddlewareTestCase
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
        $fileName = __DIR__ . '/REST/Resources/grid-example.png';

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


    protected function requestBackdropUpload(int $communityId, string $localFile, string $textColor): RESTRequest
    {
        $url = sprintf('/protected/community/%d/backdrop-upload/textColor/%s', $communityId, $textColor);

        return $this->request('POST', $url)
            ->setUploadedFiles([
                'file' => new UploadedFile($localFile, filesize($localFile), 0)
            ]);
    }

    protected function requestBackdropNone(int $communityId): RESTRequest
    {
        return $this->request('POST', sprintf('/protected/community/%d/backdrop-none', $communityId));
    }

    protected function requestBackdropColor(int $communityId, string $code): RESTRequest
    {
        $url = sprintf('/protected/community/%d/backdrop-color/code/%s/', $communityId, $code);

        return $this->request('POST', $url);
    }

    protected function requestBackdropPreset(int $communityId, string $presetId): RESTRequest
    {
        $url = sprintf('/protected/community/%d/backdrop-preset/presetId/%s/', $communityId, $presetId);

        return $this->request('POST', $url);
    }
}