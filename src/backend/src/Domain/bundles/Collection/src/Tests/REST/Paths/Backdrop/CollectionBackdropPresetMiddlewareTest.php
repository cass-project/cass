<?php
namespace CASS\Domain\Bundles\Collection\Tests\REST\Paths\Backdrop;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Collection\Tests\REST\CollectionRESTTestCase;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
final class CollectionBackdropPresetMiddlewareTest extends CollectionRESTTestCase
{
    public function testPreset403()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $this->requestBackdropPreset($collection->getId(), "1")
            ->execute()
            ->expectAuthError();
    }

    public function testPreset404()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $this->requestBackdropPreset(self::NOT_FOUND_ID, "1")
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testPreset200()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $this->requestGetById($collection->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'backdrop' => [
                        'type' => 'none'
                    ]
                ]
            ]);

        $backdropJSON = $this->requestBackdropPreset($collection->getId(), "1")
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'backdrop' => [
                    'type' => 'preset',
                    'metadata' => [
                        'preset_id' => '1',
                        'public_path' => $this->expectString(),
                        'storage_path' => $this->expectString(),
                        'text_color' => '#ffffff',
                    ]
                ]
            ])
            ->fetch(function(array $json) {
                return $json['backdrop'];
            })
        ;

        $this->requestGetById($collection->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'backdrop' => $backdropJSON
                ]
            ]);
    }
}