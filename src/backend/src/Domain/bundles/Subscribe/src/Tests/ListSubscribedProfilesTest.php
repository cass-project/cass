<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;

/**
 * @backupGlobals disabled
 */
class ListSubscribedProfilesTest extends SubscribeMiddlewareTestCase
{
    public function testListSubscribedProfilesSuccess200()
    {
        $json = [
            'offset' => 0,
            'limit'  => 100
        ];
        
        $profileId = DemoAccountFixture::getAccount()->getCurrentProfile()->getId();
        $this->requestListSubscribedProfiles($profileId, $json)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }
    public function testListSubscribedProfilesNotFound404()
    {
        $json = [
            'offset' => 0,
            'limit'  => 100
        ];

        $this->requestListSubscribedProfiles(9999, $json)
            ->execute()
            ->expectStatusCode(404);
    }
}