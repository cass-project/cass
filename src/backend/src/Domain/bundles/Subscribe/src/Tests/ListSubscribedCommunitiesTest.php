<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;

/**
 * @backupGlobals disabled
 */
class ListSubscribedCommunitiesTest extends SubscribeMiddlewareTestCase
{
    public function testListSubscribedCommunitiesSuccess200()
    {
        $json = [
            'offset' => 0,
            'limit'  => 100
        ];
        $profileId = DemoAccountFixture::getAccount()->getCurrentProfile()->getId();
        $this->requestListSubscribedCommunities($profileId, $json)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }
    public function testListSubscribedCommunitiesNotFound404()
    {
        $json = [
            'offset' => 0,
            'limit'  => 100
        ];
        $this->requestListSubscribedCommunities(999999, $json)
            ->execute()
            ->expectStatusCode(404);
    }
}