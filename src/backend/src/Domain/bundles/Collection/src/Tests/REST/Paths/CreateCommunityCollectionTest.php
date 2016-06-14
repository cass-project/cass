<?php
namespace Domain\Collection\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\REST\CollectionRESTTestCase;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
final class CreateCommunityCollectionTest extends CollectionRESTTestCase
{
    public function test200()
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

    public function test403()
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

    public function test404()
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
}