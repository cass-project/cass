<?php
namespace Domain\Collection\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class CollectionAPITest extends MiddlewareTestCase
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

    public function testCreateCommunityCollection200()
    {

        $profile = DemoProfileFixture::getProfile();
        $theme = SampleThemesFixture::getTheme(1);
        $community = SampleCommunitiesFixture::getCommunity(1);
        $json = [
            'author_profile_id' => $profile->getId(),
            'theme_id' => $theme->getId(),
            'title' => 'Demo Community Collection',
            'description' => 'Ny Demo Community Collection',
        ];

        $this->requestCreateCommunityCollection($community->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'author_profile_id' => $profile->getId(),
                    'title' => $json['title'],
                    'description' => $json['description'],
                    'theme' => [
                        'has' => true,
                        'id' => $theme->getId()
                    ]
                ]
            ])
        ;

        $collectionId = self::$currentResult->getContent()['entity']['id'];

        $this->requestGetCommunity($community->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collections = $jsonResponse['entity']['collections'];

                $this->assertTrue(is_array($collections));
                $this->assertEquals(1, count($collections));
                $this->assertEquals($collectionId, $collections[0]['collection_id']);
            })
        ;
    }

    public function testCreateCommunityCollection403()
    {
        $profile = DemoProfileFixture::getProfile();
        $theme = SampleThemesFixture::getTheme(1);
        $community = SampleCommunitiesFixture::getCommunity(1);
        $json = [
            'author_profile_id' => $profile->getId(),
            'theme_id' => $theme->getId(),
            'title' => 'Demo Community Collection',
            'description' => 'Ny Demo Community Collection',
        ];

        $this->requestCreateCommunityCollection($community->getId(), $json)
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testCreateCommunityCollection404()
    {
        $profile = DemoProfileFixture::getProfile();
        $theme = SampleThemesFixture::getTheme(1);
        $json = [
            'author_profile_id' => $profile->getId(),
            'theme_id' => $theme->getId(),
            'title' => 'Demo Community Collection',
            'description' => 'Ny Demo Community Collection',
        ];

        $this->requestCreateCommunityCollection(999999, $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(404)
        ;
    }

    public function testCreateProfileCollection200()
    {
        $profile = DemoProfileFixture::getProfile();
        $theme = SampleThemesFixture::getTheme(1);
        $json = [
            'author_profile_id' => $profile->getId(),
            'theme_id' => $theme->getId(),
            'title' => 'Demo Community Collection',
            'description' => 'Ny Demo Community Collection',
        ];

        $this->requestCreateProfileCollection($json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'title' => $json['title'],
                    'author_profile_id' => DemoProfileFixture::getProfile()->getId(),
                    'description' => $json['description'],
                    'theme' => [
                        'has' => true,
                        'id' => $theme->getId()
                    ]
                ]
            ])
        ;

        $profileId = DemoProfileFixture::getProfile()->getId();
        $collectionId = self::$currentResult->getContent()['entity']['id'];

        $this->requestGetProfile($profileId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collections = $jsonResponse['entity']['collections'];

                $this->assertTrue(is_array($collections));
                $this->assertEquals(1, count($collections));
                $this->assertEquals($collectionId, $collections[0]['collection_id']);
            })
        ;
    }

    public function testProfileDeleteCollection() {
        $this->upFixture(new SampleCollectionsFixture());

        $collectionToDelete = SampleCollectionsFixture::getProfileCollection(1);
        $collectionId = $collectionToDelete->getId();
        list($owner, $profileId) = explode(':', $collectionToDelete->getOwnerSID());

        $this->requestGetProfile($profileId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collectionIds = array_map(function(array $input) {
                    return $input['collection_id'];
                }, $jsonResponse['entity']['collections']);

                $this->assertTrue(in_array($collectionId, $collectionIds));
            })
        ;

        $this->requestDeleteCollection($collectionToDelete->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->requestGetProfile($profileId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collectionIds = array_map(function(array $input) {
                    return $input['collection_id'];
                }, $jsonResponse['entity']['collections']);

                $this->assertFalse(in_array($collectionId, $collectionIds));
            })
        ;
    }

    public function testCommunityDeleteCollection()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collectionToDelete = SampleCollectionsFixture::getCommunityCollection(1);
        $collectionId = $collectionToDelete->getId();
        list($owner, $communityId) = explode(':', $collectionToDelete->getOwnerSID());

        $this->requestGetCommunity($communityId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collectionIds = array_map(function(array $input) {
                    return $input['collection_id'];
                }, $jsonResponse['entity']['collections']);

                $this->assertTrue(in_array($collectionId, $collectionIds));
            })
        ;

        $this->requestDeleteCollection($collectionToDelete->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->requestGetCommunity($communityId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collectionIds = array_map(function(array $input) {
                    return $input['collection_id'];
                }, $jsonResponse['entity']['collections']);

                $this->assertFalse(in_array($collectionId, $collectionIds));
            })
        ;
    }

    public function testEditCollection()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collection = SampleCollectionsFixture::getCommunityCollection(1);
        $json = [
            'title' => '* my edited title',
            'description' => '* my edited description',
            'theme_id' => SampleThemesFixture::getTheme(5)->getId()
        ];

        $this->requestEditCollection($collection->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'title' => $json['title'],
                    'description' => $json['description'],
                    'theme' => [
                        'has' => true,
                        'id' => SampleThemesFixture::getTheme(5)->getId()
                    ]
                ]
            ])
        ;
    }

    public function testEditCollectionUnsetTheme()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collection = SampleCollectionsFixture::getCommunityCollection(1);
        $json = [
            'title' => '* my edited title',
            'description' => '* my edited description',
            'theme_id' => 0
        ];

        $this->requestEditCollection($collection->getId(), $json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'title' => $json['title'],
                    'description' => $json['description'],
                    'theme' => [
                        'has' => false
                    ]
                ]
            ])
        ;
    }

    private function requestCreateCommunityCollection(int $communityId, array $json): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/community/%d/collection/create', $communityId))
            ->setParameters($json);
    }

    public function requestCreateProfileCollection(array $json): RESTRequest
    {
        return $this->request('PUT', '/protected/profile/collection/create')
            ->setParameters($json);
    }

    private function requestGetCommunity(int $communityId): RESTRequest
    {
        return $this->request('GET', sprintf('/community/%d/get', $communityId));
    }

    private function requestGetProfile(int $profileId): RESTRequest
    {
        return $this->request('GET', sprintf('/profile/%d/get', $profileId));
    }

    private function requestDeleteCollection(int $collectionId): RESTRequest
    {
        return $this->request('DELETE', sprintf('/protected/collection/%d/delete', $collectionId));
    }

    private function requestEditCollection(int $collectionId, array $json): RESTRequest
    {
        return $this->request('POST', sprintf('/protected/collection/%d/edit', $collectionId))
            ->setParameters($json);
    }
}