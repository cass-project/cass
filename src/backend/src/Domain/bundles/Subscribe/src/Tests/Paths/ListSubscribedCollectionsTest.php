<?php
namespace CASS\Domain\Bundles\Subscribe\Tests\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Tests\Fixtures\DemoSubscribeFixture;
use CASS\Domain\Bundles\Subscribe\Tests\SubscribeMiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
class ListSubscribedCollectionsTest extends SubscribeMiddlewareTestCase
{
    public function test200()
    {
        $this->upFixture($fixture = new DemoSubscribeFixture());

        $json = ['offset' => 0, 'limit'  => 100];
        $profileId = DemoAccountFixture::getAccount()->getCurrentProfile()->getId();

        $this->requestListSubscribedCollections($profileId, $json)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'subscribes' => array_map(function(Subscribe $subscribe) {
                    return $subscribe->toJSON();
                }, $fixture->getSubscribes('collection')),
                'total' => count($fixture->getSubscribes('collection')),
            ]);
    }

    public function test404()
    {
        $json = ['offset' => 0, 'limit'  => 100];

        $this->requestListSubscribedCollections(self::NOT_FOUND_ID, $json)
            ->execute()
            ->expectNotFoundError();
    }
}