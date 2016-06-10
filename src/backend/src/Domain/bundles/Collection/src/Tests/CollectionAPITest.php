<?php
namespace Domain\Collection\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Application\Util\Definitions\Point;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Diactoros\UploadedFile;

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
        $theme = SampleThemesFixture::getTheme(1);
        $community = SampleCommunitiesFixture::getCommunity(1);
        $json = [
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
                    'title' => $json['title'],
                    'description' => $json['description'],
                    'has_theme' => true,
                    'theme_id' => $theme->getId()
                ]
            ])
        ;

        // Проверяем, что в указанное коммунити добавлена коллекция
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
        $theme = SampleThemesFixture::getTheme(1);
        $community = SampleCommunitiesFixture::getCommunity(1);
        $json = [
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
        $theme = SampleThemesFixture::getTheme(1);
        $json = [
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
        $theme = SampleThemesFixture::getTheme(1);
        $json = [
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
                    'description' => $json['description'],
                    'has_theme' => true,
                    'theme_id' => $theme->getId()
                ]
            ])
        ;

        // Проверяем, что в профиль добавлена коллекция
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
                    'theme_id' => SampleThemesFixture::getTheme(5)->getId()
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
                    'theme_id' => null
                ]
            ])
        ;
    }

    public function testUploadImage()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collection = SampleCollectionsFixture::getCommunityCollection(1);

        $this->requestUploadImage($collection->getId(), new Point(0, 0), new Point(200, 200))
             ->auth(DemoAccountFixture::getAccount()->getAPIKey())
             ->execute()
            ->dump()
             ->expectJSONContentType()
             ->expectStatusCode(200)
             ->expectJSONBody([
                                'success' => true,
                                'image' => [
                                  'public_path' => $this->expectString()
                                ]
                              ]);
    }

    public function testUploadImageTooBig()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collection = SampleCollectionsFixture::getCommunityCollection(1);

        $this->requestUploadImage($collection->getId(), new Point(0, 0), new Point(9999, 9999))
             ->auth(DemoAccountFixture::getAccount()->getAPIKey())
             ->execute()
             ->expectJSONContentType()
             ->expectStatusCode(422)
             ->expectJSONError();
    }

    private function requestCreateCommunityCollection(int $communityId, array $json): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/community/%d/collection/create', $communityId))
            ->setParameters($json);
    }

    public function requestCreateProfileCollection(array $json): RESTRequest
    {
        return $this->request('PUT', '/protected/profile/current/collection/create')
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

    protected function requestUploadImage(int $collectionId, Point $start, Point $end): RESTRequest
    {
        $uri = "/protected/collection/{$collectionId}/image-upload/crop-start/{$start->getX()}/{$start->getY()}/crop-end/{$end->getX()}/{$end->getY()}/";
        $fileName = __DIR__ . '/resources/grid-example.png';

        return $this->request('POST', $uri)
                    ->setUploadedFiles([
                                         'file' => new UploadedFile($fileName, filesize($fileName), 0)
                                       ]);
    }
}

