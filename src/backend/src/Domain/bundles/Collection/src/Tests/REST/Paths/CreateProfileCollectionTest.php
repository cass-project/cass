<?php
namespace Domain\Collection\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\REST\CollectionRESTTestCase;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
final class CreateProfileCollectionTest extends CollectionRESTTestCase
{
    public function test200()
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

}