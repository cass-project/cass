<?php
namespace CASS\Domain\Bundles\Collection\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\REST\CollectionRESTTestCase;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
final class GetBySIDCollectionTest extends CollectionRESTTestCase
{
    public function testGetBySID404()
    {
        $this->requestGetBySID(self::NOT_FOUND_SID)
            ->execute()
            ->expectNotFoundError();
    }

    public function testGetBySID200()
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

        $collectionSID = $this->requestCreateCollection($json)
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
                return $json['entity']['sid'];
            });

        $this->requestGetBySID($collectionSID)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'id' => $this->expectId(),
                    'sid' => $collectionSID,
                    'title' => $json['title'],
                    'description' => $json['description'],
                    'theme_ids' => $json['theme_ids']
                ]
            ]);
    }
}