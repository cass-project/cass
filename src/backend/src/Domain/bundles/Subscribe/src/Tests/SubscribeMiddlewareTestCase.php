<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;

use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Subscribe\Tests\Fixtures\DemoSubscribeFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;

/**
 * @backupGlobals disabled
 */
class SubscribeMiddlewareTestCase extends CASSMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new SampleThemesFixture(),
            new DemoProfileFixture(),
            
            new SampleCommunitiesFixture(),
            new SampleCollectionsFixture(),

            new DemoSubscribeFixture()
        ];
    }

    // Theme
    protected function requestSubscribeTheme(int $themeId): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/subscribe/subscribe-theme/%s', $themeId));
    }

    protected function requestUnSubscribeTheme(int $themeId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/subscribe/unsubscribe-theme/%s', $themeId));
    }

    protected function requestListSubscribedThemes(int $profileId, array  $json): RESTRequest
    {
        return $this->request('POST', sprintf('/subscribe/profile/%s/list-themes', $profileId))
            ->setParameters($json);
    }

    // Profile
    protected function requestSubscribeProfile(int $profileId): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/subscribe/subscribe-profile/%s', $profileId));
    }

    protected function requestUnSubscribeProfile(int $profileId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/subscribe/unsubscribe-profile/%s', $profileId));
    }

    protected function requestListSubscribedProfiles(int $profileId, array $json)
    {
        return $this->request('POST', sprintf('/subscribe/profile/%s/list-profiles', $profileId))
            ->setParameters($json);
    }

    // Collection
    protected function requestSubscribeCollection(int $collectionId): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/subscribe/subscribe-collection/%s', $collectionId));
    }

    protected function requestUnSubscribeCollection(int $collectionId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/subscribe/unsubscribe-collection/%s', $collectionId));
    }

    protected function requestListSubscribedCollections(int $profileId, array $json)
    {
        return $this->request('POST', sprintf('/subscribe/profile/%s/list-collections', $profileId))
            ->setParameters($json);
    }

    // COMMUNITY
    protected function requestSubscribeCommunity(int $communityId): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/subscribe/subscribe-community/%d', $communityId));
    }

    protected function requestUnSubscribeCommunity(int $communityId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/subscribe/unsubscribe-community/%d', $communityId));
    }

    protected function requestListSubscribedCommunities(int $profileId, array $json)
    {
        return $this->request('POST', sprintf('/subscribe/profile/%s/list-communities', $profileId))
            ->setParameters($json);
    }

}