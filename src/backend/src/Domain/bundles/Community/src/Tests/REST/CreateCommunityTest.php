<?php
namespace CASS\Domain\Bundles\Community\Tests\REST;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Tests\CommunityMiddlewareTestCase;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
final class CreateCommunityTest extends CommunityMiddlewareTestCase
{
    public function testCreateCommunity()
    {
        $theme = SampleThemesFixture::getTheme(1);
        /** @var Theme $theme */
        $json = [
            'title' => 'Community 1',
            'description' => 'My Community 1',
            'theme_id' => $theme->getId()
        ];

        $communityId = $this->requestCreateCommunity($json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
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
                            'description' => $this->expectString(),
                            'is_main' => true,
                            'is_protected' => true,
                        ]
                    ],
                    'community' => [
                        'id' => $this->expectId(),
                        'sid' => $this->expectString(),
                        'title' => 'Community 1',
                        'description' => 'My Community 1',
                        'theme' => [
                            'has' => true,
                            'id' => $theme->getId()
                        ],
                        'image' => $this->expectImageCollection(),
                        'backdrop' => [
                            'type' => 'preset'
                        ],
                        'public_options' => [
                            'public_enabled' => true,
                            'moderation_contract' => false
                        ]
                    ],
                ]
            ])
            ->expect(function(array $result) {
                $collections = $result['entity']['community']['collections'];

                $this->assertEquals(1, count($collections));
            })
            ->fetch(function(array $json) {
                return $json['entity']['community']['id'];
            });

        $this->requestGetProfile(DemoAccountFixture::getAccount()->getCurrentProfile()->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'entity' => [
                    'bookmarks' => [
                        0 => [
                            'id' => $this->expectId(),
                            'community_id' => $communityId
                        ]
                    ]
                ]
            ]);
    }

    public function testCreateCommunityWithoutTheme()
    {
        $json = [
            'title' => 'Community 1',
            'description' => 'My Community 1'
        ];

        $this->requestCreateCommunity($json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
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
                        'id' => $this->expectId(),
                        'sid' => $this->expectString(),
                        'title' => 'Community 1',
                        'description' => 'My Community 1',
                        'theme' => [
                            'has' => false,
                        ],
                        'image' => $this->expectImageCollection(),
                        'public_options' => [
                            'public_enabled' => false,
                            'moderation_contract' => false
                        ],
                        'collections' => [
                            0 => [
                                'collection_id' => $this->expectId(),
                                'position' => 1
                            ]
                        ]
                    ],
                ],
            ])
            ->expect(function(array $result) {
                $collections = $result['entity']['community']['collections'];

                $this->assertEquals(1, count($collections));
            });
    }

    public function testCreateCommunity403()
    {
        $theme = SampleThemesFixture::getTheme(1);
        /** @var Theme $theme */
        $json = [
            'title' => 'Community 1',
            'description' => 'My Community 1',
            'theme_id' => $theme->getId()
        ];

        $this->requestCreateCommunity($json)
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(403)
            ->expectJSONError();
    }
}