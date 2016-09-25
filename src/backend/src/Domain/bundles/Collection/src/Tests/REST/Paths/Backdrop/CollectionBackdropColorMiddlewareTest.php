<?php
namespace CASS\Domain\Bundles\Collection\Tests\REST\Paths\Backdrop;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Collection\Tests\Fixtures\SampleCollectionsFixture;
use CASS\Domain\Bundles\Collection\Tests\REST\CollectionRESTTestCase;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
final class CollectionBackdropColorMiddlewareTest extends CollectionRESTTestCase
{
    public function testColor403()
    {
        $this->upFixture(new SampleCollectionsFixture());

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();
        $collection = SampleCollectionsFixture::getProfileCollection(1);

        $this->requestBackdropColor($collection->getId(), 'red')
            ->execute()
            ->expectAuthError();
    }

    public function testColor404()
    {
        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $this->requestBackdropColor(self::NOT_FOUND_ID, 'red')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testColor200()
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
                        'type' => 'preset'
                    ]
                ]
            ]);

        $backdropJSON = $this->requestBackdropColor($collection->getId(), 'red')
            ->auth($account->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'backdrop' => [
                    'type' => 'color',
                    'metadata' => [
                        'palette' => [
                            'code' => 'red',
                            'background' => [
                                'code' => 'red.500',
                                'hexCode' => $this->expectString(),
                            ],
                            'foreground' => [
                                'code' => 'red.50',
                                'hexCode' => $this->expectString(),
                            ],
                            'border' => [
                                'code' => 'red.900',
                                'hexCode' => $this->expectString(),
                            ]
                        ]
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