<?php
namespace CASS\Domain\Bundles\Community\Tests\REST;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Tests\CommunityMiddlewareTestCase;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;

/**
 * @backupGlobals disabled
 */
final class DeleteCommunityImageTest extends CommunityMiddlewareTestCase
{
    public function testDeleteCommunityImage403()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $this->requestDeleteImage(SampleCommunitiesFixture::getCommunity(1)->getId())
            ->execute()
            ->expectAuthError();
    }

    public function testDeleteCommunityImage404()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $this->requestDeleteImage(999999999999)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectNotFoundError();
    }

    public function testDeleteCommunityImage200()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $this->requestDeleteImage(SampleCommunitiesFixture::getCommunity(1)->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'image' => $this->expectImageCollection()
            ])
            ->expectJSONBody([
                'image' => [
                    'is_auto_generated' => true
                ]
            ])
        ;
    }
}