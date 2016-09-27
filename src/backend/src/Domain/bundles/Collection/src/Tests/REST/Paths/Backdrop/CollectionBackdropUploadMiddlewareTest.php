<?php
namespace CASS\Domain\Bundles\Collection\Tests\REST\Paths\Backdrop;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Collection\Tests\REST\CollectionRESTTestCase;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
final class CollectionBackdropUploadMiddlewareTest extends CollectionRESTTestCase
{
    public function testBackdropUpload403()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $localFile = __DIR__ . '/../Resources/grid500x500.png';

        $this->requestBackdropUpload($collection->getId(), $localFile, 'ffffff')
            ->execute()
            ->expectAuthError();
    }

    public function testBackdropUpload404()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $localFile = __DIR__ . '/../Resources/grid500x500.png';

        $this->requestBackdropUpload(self::NOT_FOUND_ID, $localFile, 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testBackdropUpload200()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $localFile = __DIR__ . '/../Resources/grid500x500.png';

        $this->requestGetById($collection->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'backdrop' => [
                        'type' => 'preset'
                    ]
                ]
            ]);

        $backdropJSON = $this->requestBackdropUpload($collection->getId(), $localFile, 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'backdrop' => [
                    'type' => 'uploaded',
                    'metadata' => [
                        'public_path' => $this->expectString(),
                        'storage_path' => $this->expectString(),
                        'text_color' => 'ffffff'
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

    public function testBackdropUploadTestSizes()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $this->requestBackdropUpload($collection->getId(), __DIR__ . '/../Resources/grid399x399.png', 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString(),
            ]);

        $this->requestBackdropUpload($collection->getId(), __DIR__ . '/../Resources/grid500x500.png', 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'backdrop' => [
                    'type' => 'uploaded',
                    'metadata' => [
                        'public_path' => $this->expectString(),
                        'storage_path' => $this->expectString(),
                        'text_color' => 'ffffff'
                    ]
                ]
            ]);

        $this->requestBackdropUpload($collection->getId(), __DIR__ . '/../Resources/grid400x400.png', 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'backdrop' => [
                    'type' => 'uploaded',
                    'metadata' => [
                        'public_path' => $this->expectString(),
                        'storage_path' => $this->expectString(),
                        'text_color' => 'ffffff'
                    ]
                ]
            ]);

        $this->requestBackdropUpload($collection->getId(), __DIR__ . '/../Resources/grid2048x2048.png', 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'backdrop' => [
                    'type' => 'uploaded',
                    'metadata' => [
                        'public_path' => $this->expectString(),
                        'storage_path' => $this->expectString(),
                        'text_color' => 'ffffff'
                    ]
                ]
            ]);

        $this->requestBackdropUpload($collection->getId(), __DIR__ . '/../Resources/grid2049x2049.png', 'ffffff')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString(),
            ]);
    }
}