<?php
namespace Domain\Collection\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
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

    public function testCreateCommunityCollection()
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

    private function requestCreateCommunityCollection(int $communityId, array $json): RESTRequest
    {
        return $this->request('PUT', sprintf('/protected/community/%d/collection/create', $communityId))
            ->setParameters($json);
    }

    private function requestGetCommunity(int $communityId)
    {
        return $this->request('GET', sprintf('/community/%d/get', $communityId));
    }
}