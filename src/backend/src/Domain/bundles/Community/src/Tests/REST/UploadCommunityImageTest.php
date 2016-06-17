<?php
namespace Domain\Community\Tests\REST;

use Application\Util\Definitions\Point;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Entity\Community;
use Domain\Community\Tests\CommunityMiddlewareTestCase;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;

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
                'image' => [
                    'public_path' => $this->expectString()
                ]
            ]);
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