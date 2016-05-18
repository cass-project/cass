<?php
namespace Domain\Community\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Application\Util\Definitions\Point;
use Zend\Diactoros\UploadedFile;

abstract class CommunityMiddlewareTestCase extends MiddlewareTestCase
{
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

    protected function requestGetCommunityById(int $communityId): RESTRequest
    {
        return $this->request('GET', sprintf('/community/%d/get', $communityId));
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
}