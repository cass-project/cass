<?php
namespace CASS\Domain\Bundles\Community\Tests\REST;

use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Tests\CommunityMiddlewareTestCase;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;

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
                    'is_own' => true,
                    'collections' => [
                        0 => [
                            'id' => $this->expectId(),
                            'sid' => $this->expectString(),
                            'owner_sid' => $this->expectString(),
                            'owner' => [
                                'id' => $this->expectString(),
                                'type' => 'community'
                            ],
                            'title' => $this->expectString(),
                            'description' => $this->expectString()
                        ]
                    ],
                    'community' => [
                        'title' => $sampleCommunity->getTitle(),
                        'description' => $sampleCommunity->getDescription(),
                        'theme' => [
                            'has' => true,
                            'id' => $sampleCommunity->getTheme()->getId()
                        ],
                        'image' => $this->expectImageCollection(),
                    ],
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