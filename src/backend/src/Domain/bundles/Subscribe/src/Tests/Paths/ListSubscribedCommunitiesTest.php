<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Tests\Fixtures\DemoSubscribeFixture;
use CASS\Domain\Bundles\Subscribe\Tests\SubscribeMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class ListSubscribedCommunitiesTest extends SubscribeMiddlewareTestCase
{
    public function test200()
    {
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $json = ['offset' => 0, 'limit'  => 100];
        $profileId = DemoAccountFixture::getAccount()->getCurrentProfile()->getId();

        $this->requestListSubscribedCommunities($profileId, $json)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'subscribes' => array_map(function(Subscribe $subscribe) {
                    return $subscribe->toJSON();
                }, $fixture->getSubscribes('community')),
                'total' => count($fixture->getSubscribes('community')),
            ]);
    }
    public function test404()
    {
        $json = ['offset' => 0, 'limit'  => 100];

        $this->requestListSubscribedCommunities(self::NOT_FOUND_ID, $json)
            ->execute()
            ->expectNotFoundError();
    }
}