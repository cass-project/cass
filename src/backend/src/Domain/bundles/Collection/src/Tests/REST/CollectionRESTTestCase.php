<?php
namespace Domain\Collection\Tests\REST;

use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Application\PHPUnit\RESTRequest\RESTRequest;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

abstract class CollectionRESTTestCase extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
        ];
    }

    protected function requestCreateCommunityCollection(int $communityId, array $json): RESTRequest {
        return $this->request('PUT', sprintf('/protected/community/%d/collection/create', $communityId))
            ->setParameters($json);
    }

    protected function requestCreateProfileCollection(array $json): RESTRequest {
        return $this->request('PUT', '/protected/profile/collection/create')
            ->setParameters($json);
    }

    protected function requestGetCommunity(int $communityId): RESTRequest {
        return $this->request('GET', sprintf('/community/%d/get', $communityId));
    }

    protected function requestGetProfile(int $profileId): RESTRequest {
        return $this->request('GET', sprintf('/profile/%d/get', $profileId));
    }

    protected function requestDeleteCollection(int $collectionId): RESTRequest {
        return $this->request('DELETE', sprintf('/protected/collection/%d/delete', $collectionId));
    }

    protected function requestEditCollection(int $collectionId, array $json): RESTRequest {
        return $this->request('POST', sprintf('/protected/collection/%d/edit', $collectionId))
            ->setParameters($json);
    }

    protected function requestSetPublicOptions(int $collectionId, array $json): RESTRequest
    {
        return $this->request('POST', sprintf('/protected/collection/%d/set-public-options', $collectionId))
            ->setParameters($json);
    }
}