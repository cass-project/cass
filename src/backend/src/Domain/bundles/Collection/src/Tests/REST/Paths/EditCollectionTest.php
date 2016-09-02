<?php
namespace CASS\Domain\Bundles\Collection\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Collection\Tests\REST\CollectionRESTTestCase;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
final class EditCollectionTest extends CollectionRESTTestCase
{
    public function test200()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collection = SampleCollectionsFixture::getCommunityCollection(1);
        $json = [
            'title' => '* my edited title',
            'description' => '* my edited description',
            'theme_ids' => [
                SampleThemesFixture::getTheme(3)->getId(),
                SampleThemesFixture::getTheme(5)->getId()
            ]
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
                    'theme_ids' => $json['theme_ids']
                ]
            ]);
    }

    public function test200UnsetTheme()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $collection = SampleCollectionsFixture::getCommunityCollection(1);
        $json = [
            'title' => '* my edited title',
            'description' => '* my edited description',
            'theme_ids' => []
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
                    'theme_ids' => $json['theme_ids']
                ]
            ]);
    }
}