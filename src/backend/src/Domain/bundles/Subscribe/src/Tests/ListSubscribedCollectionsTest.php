<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;

/**
 * @backupGlobals disabled
 */
class ListSubscribedCollectionsTest extends SubscribeMiddlewareTestCase
{
    public function testListSubscribedCollectionsSuccess200()
    {
        $json = [
            'offset' => 0,
            'limit'  => 100
        ];
        $profileId = DemoAccountFixture::getAccount()->getCurrentProfile()->getId();
        $this->requestListSubscribedCollections($profileId, $json)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }

    public function testListSubscribedCollectionsNotFound404()
    {
        $json = [
            'offset' => 0,
            'limit'  => 100
        ];
        $this->requestListSubscribedCollections(99999, $json)
            ->execute()
            ->expectStatusCode(404);
    }
}