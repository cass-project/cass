<?php
namespace CASS\Domain\Bundles\Subscribe\Tests;
use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;

/**
 * @backupGlobals disabled
 */
class ListSubscribedThemesTest extends SubscribeMiddlewareTestCase
{
    public function testListSubscribedThemesSuccess200()
    {
        $json = [
            'offset' => 0,
            'limit'  => 100
        ];
        $profileId = DemoAccountFixture::getAccount()->getCurrentProfile()->getId();
        $this->requestListSubscribedThemes($profileId, $json)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
            ]);
    }
    public function testListSubscribedThemesNotFoundProfile403()
    {
        $json = [
            'offset' => 0,
            'limit'  => 100
        ];

        $this->requestListSubscribedThemes(99999, $json)
            ->execute()
            ->expectStatusCode(404);
    }

}