<?php
namespace CASS\Domain\Bundles\Collection\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\REST\CollectionRESTTestCase;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
final class GetByIDCollectionTest extends CollectionRESTTestCase
{
    public function testGetById404()
    {
        $this->requestGetById(self::NOT_FOUND_ID)
            ->execute()
            ->expectNotFoundError();
    }

    public function testGetById200()
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

        $collectionId = $this->requestCreateCollection($json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'sid' => $this->expectString(),
                    'title' => $json['title'],
                    'description' => $json['description'],
                    'theme_ids' => $json['theme_ids']
                ]
            ])
            ->fetch(function(array $json) {
                return $json['entity']['id'];
            });

        $this->requestGetById($collectionId)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'id' => $collectionId,
                    'sid' => $this->expectString(),
                    'title' => $json['title'],
                    'description' => $json['description'],
                    'theme_ids' => $json['theme_ids']
                ]
            ]);
    }
}