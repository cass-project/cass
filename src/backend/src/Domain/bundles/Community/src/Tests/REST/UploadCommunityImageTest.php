<?php
namespace CASS\Domain\Community\Tests\REST;

use CASS\Util\Definitions\Point;
use CASS\Domain\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Community\Entity\Community;
use CASS\Domain\Community\Tests\CommunityMiddlewareTestCase;
use CASS\Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;

/**
 * @backupGlobals disabled
 */
final class UploadCommunityImageTest extends CommunityMiddlewareTestCase
{
    public function testUploadImage()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $sampleCommunity = SampleCommunitiesFixture::getCommunity(2);

        $this->requestUploadImage($sampleCommunity->getId(), new Point(0, 0), new Point(200, 200))
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'image' => $this->expectImageCollection()
            ])
            ->expectJSONBody([
                'image' => [
                    'is_auto_generated' => false
                ]
            ])
        ;
    }

    public function testUploadImageTooBig()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $sampleCommunity = SampleCommunitiesFixture::getCommunity(2);

        $this->requestUploadImage($sampleCommunity->getId(), new Point(0, 0), new Point(9999, 9999))
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(422)
            ->expectJSONError();
    }
}