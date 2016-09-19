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

    protected function requestSubscribeTheme(int $themeId): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/subscribe/subscribe-theme/%s', $themeId));
    }

    protected function requestUnSubscribeTheme(int $themeId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/subscribe/unsubscribe-theme/%s', $themeId));
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

    // Collection

    protected function requestSubscribeCollection(int $collectionId): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/subscribe/subscribe-collection/%s', $collectionId));
    }

    protected function requestUnSubscribeCollection(int $collectionId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/subscribe/unsubscribe-collection/%s', $collectionId));
    }

    // COMMUNITY

}