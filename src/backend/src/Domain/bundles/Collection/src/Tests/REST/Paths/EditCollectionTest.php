<?php
namespace Domain\Collection\Tests\REST\Paths;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Collection\Tests\Fixtures\SampleCollectionsFixture;
use Domain\Collection\Tests\REST\CollectionRESTTestCase;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

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

    public function test200UnsetTheme()
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
}