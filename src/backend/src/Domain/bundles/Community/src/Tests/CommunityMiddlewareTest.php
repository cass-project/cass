<?php
namespace Domain\Community\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\Util\Definitions\Point;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Entity\Community;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Diactoros\UploadedFile;

/**
 * @backupGlobals disabled
 */
class CommunityMiddlewareTest extends CommunityMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
        ];
    }

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
                    'public_options' => [
                        'public_enabled' => false,
                        'moderation_contract' => false
                    ]
                ]
            ])
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
                    'title' => '* title_edited',
                    'description' => '* description_edited',
                    'theme' => [
                        'has' => true,
                        'id' => $moveToTheme->getId()
                    ]
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
                    'title' => '* title_edited',
                    'description' => '* description_edited',
                    'theme' => [
                        'has' => false,
                    ]
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
                    'title' => '* title_edited',
                    'description' => '* description_edited',
                    'theme' => [
                        'has' => true,
                        'id' => $moveToTheme->getId()
                    ]
                ]
            ]);
    }

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

    public function testSetPublicOptions200()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $sampleCommunity = SampleCommunitiesFixture::getCommunity(2);

        $this->requestGetCommunityById($sampleCommunity->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'id' => $sampleCommunity->getId(),
                    'public_options' => [
                        'public_enabled' => true,
                        'moderation_contract' => false
                    ]
                ]
        ]);

        $this->requestSetPublicOptions($sampleCommunity->getId(), [
            'public_enabled' => true,
            'moderation_contract' => true
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
        ;

        $this->requestGetCommunityById($sampleCommunity->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'id' => $sampleCommunity->getId(),
                    'public_options' => [
                        'public_enabled' => true,
                        'moderation_contract' => true
                    ]
                ]
            ]);

        $this->requestSetPublicOptions($sampleCommunity->getId(), [
            'public_enabled' => false,
            'moderation_contract' => false
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
        ;

        $this->requestGetCommunityById($sampleCommunity->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'id' => $sampleCommunity->getId(),
                    'public_options' => [
                        'public_enabled' => false,
                        'moderation_contract' => false
                    ]
                ]
            ]);
    }

    public function testSetPublicOptions409()
    {
        $id = null;
        $json = [
            'title' => 'Community 1',
            'description' => 'My Community 1'
        ];

        $this->requestCreateCommunity($json)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->with(function(array $result) use (&$id) {
                $id = (int) $result['entity']['id'];
            })
        ;

        $this->assertTrue($id > 0);


        $this->requestSetPublicOptions($id, [
            'public_enabled' => false,
            'moderation_contract' => false
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
        ;


        $this->requestSetPublicOptions($id, [
            'public_enabled' => false,
            'moderation_contract' => true
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
        ;

        $this->requestSetPublicOptions($id, [
            'public_enabled' => true,
            'moderation_contract' => false
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
        ;
    }

    public function testDoNotResetModerationContract()
    {
        $this->upFixture(new SampleCommunitiesFixture());

        $sampleCommunity = SampleCommunitiesFixture::getCommunity(2);

        $this->requestSetPublicOptions($sampleCommunity->getId(), [
            'public_enabled' => true,
            'moderation_contract' => true
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
        ;

        $this->requestEditCommunity($sampleCommunity->getId(), [
            'title' => '* title_edited',
            'description' => '* description_edited',
        ])->auth(DemoAccountFixture::getAccount()->getAPIKey())->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200);
        ;

        $this->requestGetCommunityById($sampleCommunity->getId())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'entity' => [
                    'id' => $sampleCommunity->getId(),
                    'public_options' => [
                        'public_enabled' => false,
                        'moderation_contract' => true
                    ]
                ]
            ]);
    }
}