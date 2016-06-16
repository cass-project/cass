<?php
namespace Domain\Community\Tests\REST;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Entity\Community;
use Domain\Community\Tests\CommunityMiddlewareTestCase;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;

/**
 * @backupGlobals disabled
 */
final class SetPublicOptionsTest extends CommunityMiddlewareTestCase
{
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