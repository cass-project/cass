<?php
namespace Domain\ProfileCommunities\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\ProfileCommunities\Tests\Fixtures\SamplePCBookmarksFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class ProfileCommunitiesAPITest extends MiddlewareTestCase
{
    protected function getFixtures(): array {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture(),
        ];
    }

    public function testJoinCommunity() {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestJoin($community->getSID())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'profile_id' => DemoProfileFixture::getProfile()->getId(),
                    'community' => $community->toJSON()
                ]
            ])
        ;
    }

    public function testJoinCommunity403() {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestJoin($community->getSID())
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testJoinCommunity409() {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestJoin($community->getSID())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute();

        $this->requestJoin($community->getSID())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(409)
            ->expectJSONError()
        ;
    }

    public function testLeaveCommunity() {
        $this->upFixture(new SamplePCBookmarksFixture());

        $community = SampleCommunitiesFixture::getCommunity(2);

        $this->requestLeave($community->getSID())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;
    }

    public function testLeaveCommunity403() {
        $this->upFixture(new SamplePCBookmarksFixture());

        $community = SampleCommunitiesFixture::getCommunity(2);

        $this->requestLeave($community->getSID())
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testLeaveCommunity409() {
        $this->upFixture(new SamplePCBookmarksFixture());

        $community = SampleCommunitiesFixture::getCommunity(2);

        $this->requestLeave($community->getSID())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
        ;

        $this->requestLeave($community->getSID())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(409)
            ->expectJSONError()
        ;
    }

    public function testListCommunities() {
        $this->upFixture(new SamplePCBookmarksFixture());

        $this->requestList()
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'bookmarks' => [
                    SamplePCBookmarksFixture::getBookmark(1)->toJSON(),
                    SamplePCBookmarksFixture::getBookmark(2)->toJSON(),
                    SamplePCBookmarksFixture::getBookmark(3)->toJSON(),
                    SamplePCBookmarksFixture::getBookmark(4)->toJSON(),
                    SamplePCBookmarksFixture::getBookmark(5)->toJSON(),
                ]
            ]);
        ;
    }

    public function testListCommunities403() {
        $this->upFixture(new SamplePCBookmarksFixture());

        $this->requestList()
            ->execute()
            ->expectAuthError()
        ;
    }

    private function requestJoin(string $communitySID): RESTRequest {
        return $this->request('PUT', sprintf('/protected/community/%s/join', $communitySID));
    }

    private function requestLeave(string $communitySID): RESTRequest {
        return $this->request('DELETE', sprintf('/protected/community/%s/leave', $communitySID));
    }

    private function requestList(): RESTRequest {
        return $this->request('GET', '/protected/profile/current/joined-communities');
    }
}