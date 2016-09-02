<?php
namespace CASS\Domain\Bundles\Community\Tests\REST;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Tests\CommunityMiddlewareTestCase;
use CASS\Domain\Bundles\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
final class EditCommunityTest extends CommunityMiddlewareTestCase
{
    public function testEditCommunity()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $sampleCommunity = SampleCommunitiesFixture::getCommunity(2);
        $moveToTheme = SampleThemesFixture::getTheme(5);

        $this->requestEditCommunity($sampleCommunity->getId(), [
            'title' => '* title_edited',
            'description' => '* description_edited',
            'theme_id' => $moveToTheme->getId()
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
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
                        'title' => '* title_edited',
                        'description' => '* description_edited',
                        'theme' => [
                            'has' => true,
                            'id' => $moveToTheme->getId()
                        ]
                    ],
                ]
            ]);
    }

    public function testEditCommunityWithoutTheme()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $sampleCommunity = SampleCommunitiesFixture::getCommunity(2);
        $moveToTheme = SampleThemesFixture::getTheme(5);

        $this->requestEditCommunity($sampleCommunity->getId(), [
            'title' => '* title_edited',
            'description' => '* description_edited',
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
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
                        'title' => '* title_edited',
                        'description' => '* description_edited',
                        'theme' => [
                            'has' => false,
                        ]
                    ],
                ]
            ]);
    }

    public function testSetTheme()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $sampleCommunity = SampleCommunitiesFixture::getCommunity(2);
        $moveToTheme = SampleThemesFixture::getTheme(5);

        $this->requestEditCommunity($sampleCommunity->getId(), [
            'title' => '* title_edited',
            'description' => '* description_edited',
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200);

        $this->requestEditCommunity($sampleCommunity->getId(), [
            'title' => '* title_edited',
            'description' => '* description_edited',
            'theme_id' => $moveToTheme->getId()
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
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
                        'title' => '* title_edited',
                        'description' => '* description_edited',
                        'theme' => [
                            'has' => true,
                            'id' => $moveToTheme->getId()
                        ]
                    ],
                ]
            ]);
    }
}