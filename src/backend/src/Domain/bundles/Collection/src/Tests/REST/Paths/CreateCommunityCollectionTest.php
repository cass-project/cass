<?php
namespace CASS\Domain\Collection\Tests\REST\Paths;

use CASS\Domain\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Collection\Tests\REST\CollectionRESTTestCase;
use CASS\Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
final class CreateCommunityCollectionTest extends CollectionRESTTestCase
{
    public function test403()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $json = [
            'owner_sid' => sprintf('community:%s', $community->getId()),
            'title' => 'Demo Community Collection',
            'description' => 'My Demo Community Collection',
            'theme_ids' => [
                SampleThemesFixture::getTheme(1)->getId(),
                SampleThemesFixture::getTheme(2)->getId(),
                SampleThemesFixture::getTheme(3)->getId(),
            ],
        ];

        $this->requestCreateCollection($json)
            ->execute()
            ->expectAuthError();
    }

    public function test404()
    {
        $json = [
            'owner_sid' => sprintf('community:%s', 9999999),
            'title' => 'Demo Community Collection',
            'description' => 'My Demo Community Collection',
            'theme_ids' => [
                SampleThemesFixture::getTheme(1)->getId(),
                SampleThemesFixture::getTheme(2)->getId(),
                SampleThemesFixture::getTheme(3)->getId(),
            ],
        ];

        $this->requestCreateCollection($json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->dump()
            ->expectStatusCode(404);
    }

    public function test200()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $json = [
            'owner_sid' => sprintf('community:%s', $community->getId()),
            'title' => 'Demo Community Collection',
            'description' => 'My Demo Community Collection',
            'theme_ids' => [
                SampleThemesFixture::getTheme(1)->getId(),
                SampleThemesFixture::getTheme(2)->getId(),
                SampleThemesFixture::getTheme(3)->getId(),
            ],
        ];

        $this->requestCreateCollection($json)
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
                    'theme_ids' => $json['theme_ids'],
                    'image' => $this->expectImageCollection()
                ]
            ])
            ->expectJSONBody([
                'entity' => [
                    'image' => [
                        'is_auto_generated' => true
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
                $collections = $jsonResponse['entity']['community']['collections'];

                $this->assertTrue(is_array($collections));
                $this->assertEquals(2, count($collections));
                $this->assertEquals($collectionId, $collections[1]['collection_id']);
            });
    }
}