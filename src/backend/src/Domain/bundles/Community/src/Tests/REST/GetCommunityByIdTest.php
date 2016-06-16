<?php
namespace Domain\Community\Tests\REST;

use Domain\Community\Entity\Community;
use Domain\Community\Tests\CommunityMiddlewareTestCase;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;

/**
 * @backupGlobals disabled
 */
final class GetCommunityByIdTest extends CommunityMiddlewareTestCase
{
    public function testCommunityGetById()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $sampleCommunity = SampleCommunitiesFixture::getCommunity(2);

        $this->requestGetCommunityById($sampleCommunity->getId())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'title' => $sampleCommunity->getTitle(),
                    'description' => $sampleCommunity->getDescription(),
                    'theme' => [
                        'has' => true,
                        'id' => $sampleCommunity->getTheme()->getId()
                    ]
                ]
            ]);
    }

    public function testCommunityGetByIdNotFound()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $this->requestGetCommunityById(999999)
            ->execute()
            ->expectStatusCode(404)
            ->expectJSONContentType()
            ->expectJSONError();
    }
}