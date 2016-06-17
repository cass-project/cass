<?php
namespace Domain\Community\Tests\REST;

use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Community\Entity\Community;
use Domain\Community\Tests\CommunityMiddlewareTestCase;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;

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
}