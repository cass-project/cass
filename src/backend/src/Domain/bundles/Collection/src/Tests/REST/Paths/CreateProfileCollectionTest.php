<?php
namespace CASS\Domain\Bundles\Collection\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\REST\CollectionRESTTestCase;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
final class CreateProfileCollectionTest extends CollectionRESTTestCase
{
    public function test200()
    {
        $profile = DemoProfileFixture::getProfile();

        $json = [
            'owner_sid' => sprintf('profile:%s', $profile->getId()),
            'title' => 'Demo Profile Collection',
            'description' => 'My Demo Profile Collection',
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
                    'theme_ids' => $json['theme_ids']
                ]
            ]);

        $profileId = DemoProfileFixture::getProfile()->getId();
        $collectionId = self::$currentResult->getContent()['entity']['id'];

        $this->requestGetProfile($profileId)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expect(function(array $jsonResponse) use ($collectionId) {
                $collections = $jsonResponse['entity']['profile']['collections'];

                $this->assertTrue(is_array($collections));
                $this->assertEquals(2, count($collections));
                $this->assertEquals($collectionId, $collections[1]['collection_id']);
            });
    }

}