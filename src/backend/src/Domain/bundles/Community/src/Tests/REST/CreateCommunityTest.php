<?php
namespace Domain\Community\Tests\REST;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Entity\Community;
use Domain\Community\Tests\CommunityMiddlewareTestCase;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

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

        $this->requestCreateCommunity($json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'id' => $this->expectId(),
                    'sid' => $this->expectString(),
                    'title' => 'Community 1',
                    'description' => 'My Community 1',
                    'theme' => [
                        'has' => true,
                        'id' => $theme->getId()
                    ],
                    'image' => [
                        'uid' => $this->expectString(),
                        'variants' => [
                            'default' => [
                                'id' => 'default',
                                'storage_path' => $this->expectString(),
                                'public_path' => $this->expectString(),
                            ]
                        ]
                    ],
                    'public_options' => [
                        'public_enabled' => true,
                        'moderation_contract' => false
                    ]
                ]
            ])
            ->expect(function(array $result) {
                $sid = $result['entity']['sid'];

                $this->assertEquals(Community::SID_LENGTH, strlen($sid));
            });
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
                    'id' => $this->expectId(),
                    'sid' => $this->expectString(),
                    'title' => 'Community 1',
                    'description' => 'My Community 1',
                    'theme' => [
                        'has' => false,
                    ],
                    'image' => [
                        'uid' => $this->expectString(),
                        'variants' => [
                            'default' => [
                                'id' => 'default',
                                'storage_path' => $this->expectString(),
                                'public_path' => $this->expectString(),
                            ]
                        ]
                    ],
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
            ])
            ->expect(function(array $result) {
                $collections = $result['entity']['collections'];

                $this->assertEquals(1, count($collections));
            })
            ->expect(function(array $result) {
                $sid = $result['entity']['sid'];

                $this->assertEquals(Community::SID_LENGTH, strlen($sid));
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