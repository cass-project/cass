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
        $profile = DemoAccountFixture::getSecondAccount()->getCurrentProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestJoin($profile->getId(),$community->getSID())
            ->auth(DemoAccountFixture::getSecondAccount()->getAPIKey())
            ->execute()
            ->dump()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'profile_id' => $profile->getId(),
                    'community' => $community->toJSON()
                ]
            ])
        ;
    }

    public function testJoinCommunity403() {
        $profile = DemoAccountFixture::getSecondAccount()->getCurrentProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestJoin($profile->getId(), $community->getSID())
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testJoinCommunity403NotOwner() {
        $profile = DemoAccountFixture::getSecondAccount()->getCurrentProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestJoin($profile->getId(), $community->getSID())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testJoinCommunity409() {
        $profile = DemoAccountFixture::getSecondAccount()->getCurrentProfile();
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestJoin($profile->getId(), $community->getSID())
            ->auth(DemoAccountFixture::getSecondAccount()->getAPIKey())
            ->execute();

        $this->requestJoin($profile->getId(), $community->getSID())
            ->auth(DemoAccountFixture::getSecondAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(409)
            ->expectJSONError()
        ;
    }

    public function testLeaveCommunity() {
        $this->upFixture(new SamplePCBookmarksFixture());

        $profile = DemoAccountFixture::getSecondAccount()->getCurrentProfile();
        $community = SampleCommunitiesFixture::getCommunity(2);

        $this->requestLeave($profile->getId(), $community->getSID())
            ->auth(DemoAccountFixture::getSecondAccount()->getAPIKey())
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

        $profile = DemoAccountFixture::getSecondAccount()->getCurrentProfile();
        $community = SampleCommunitiesFixture::getCommunity(2);

        $this->requestLeave($profile->getId(), $community->getSID())
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testLeaveCommunity409() {
        $this->upFixture(new SamplePCBookmarksFixture());

        $profile = DemoAccountFixture::getSecondAccount()->getCurrentProfile();
        $community = SampleCommunitiesFixture::getCommunity(2);

        $this->requestLeave($profile->getId(), $community->getSID())
            ->auth(DemoAccountFixture::getSecondAccount()->getAPIKey())
            ->execute()
        ;

        $this->requestLeave($profile->getId(), $community->getSID())
            ->auth(DemoAccountFixture::getSecondAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(409)
            ->expectJSONError()
        ;
    }

    public function testListCommunities() {
        $profile = DemoAccountFixture::getSecondAccount()->getCurrentProfile();

        $this->upFixture(new SamplePCBookmarksFixture());

        $this->requestList($profile->getId())
            ->auth(DemoAccountFixture::getSecondAccount()->getAPIKey())
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

        $profile = DemoAccountFixture::getSecondAccount()->getCurrentProfile();

        $this->requestList($profile->getId())
            ->execute()
            ->expectAuthError()
        ;
    }

    private function requestJoin(int $profileId, string $communitySID): RESTRequest {
        return $this->request('PUT', sprintf('/protected/with-profile/%s/community/%s/join', $profileId, $communitySID));
    }

    private function requestLeave(int $profileId, string $communitySID): RESTRequest {
        return $this->request('DELETE', sprintf('/protected/with-profile/%s/community/%s/leave', $profileId, $communitySID));
    }

    private function requestList(int $profileId): RESTRequest {
        return $this->request('GET', sprintf('/protected/with-profile/%s/community/list/joined-communities', $profileId));
    }
}