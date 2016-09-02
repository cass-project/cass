<?php
namespace CASS\Domain\Community\Tests;

use CASS\Domain\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Community\Feature\Features\BoardsFeature;
use CASS\Domain\Community\Feature\Features\ChatFeature;
use CASS\Domain\Community\Feature\Features\CollectionsFeature;
use CASS\Domain\Community\Feature\FeaturesFactory;
use CASS\Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use CASS\Domain\Profile\Tests\Fixtures\DemoProfileFixture;
use CASS\Domain\Theme\Tests\Fixtures\SampleThemesFixture;

/**
 * @backupGlobals disabled
 */
class CommunityFeatureMiddlewareTest extends CommunityMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture(),
            new SampleThemesFixture(),
            new SampleCommunitiesFixture()
        ];
    }

    /**
     * @throws \DI\NotFoundException
     */
    public function testDoNotActivateFeatureBeforeISay()
    {
        /** @var FeaturesFactory $service */
        $service = $this->container()->get(FeaturesFactory::class);
        $expected = [
            CollectionsFeature::class => [
                'code' => 'collections',
                'is_development_ready' => true,
                'is_production_ready' => true,
            ],
            BoardsFeature::class => [
                'code' => 'boards',
                'is_development_ready' => false,
                'is_production_ready' => false,
            ],
            ChatFeature::class => [
                'code' => 'chat',
                'is_development_ready' => false,
                'is_production_ready' => false,
            ],
        ];

        foreach($service->listFeatures() as $className) {
            $feature = $service->createFeatureFromClassName($className);

            $this->assertTrue(isset($expected[$className]));
            $this->assertEquals($expected[$className]['code'], $feature->getCode());
            $this->assertEquals($expected[$className]['is_development_ready'], $feature->isDevelopmentReady());
            $this->assertEquals($expected[$className]['is_production_ready'], $feature->isProductionReady());
        }
    }

    public function testActivateFeature403()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestActivateFeature($community->getId(), CollectionsFeature::getCode())
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testActivateFeature404()
    {
        $this->requestActivateFeature(9999999, CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(404)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString()
            ])
        ;
    }

    public function testActivateFeature200()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestActivateFeature($community->getId(), CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;
    }

    public function testActivateFeature409()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestActivateFeature($community->getId(), CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->requestActivateFeature($community->getId(), CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false
            ])
        ;
    }

    public function testDeactivateFeature403()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestDeactivateFeature($community->getId(), CollectionsFeature::getCode())
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testDeactivateFeature404()
    {
        $this->requestDeactivateFeature(9999999, CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(404)
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString()
            ])
        ;
    }

    public function testDeactivateFeature200()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestActivateFeature($community->getId(), CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->requestDeactivateFeature($community->getId(), CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;
    }

    public function testDeactivateFeature409()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestActivateFeature($community->getId(), CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->requestDeactivateFeature($community->getId(), CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;

        $this->requestDeactivateFeature($community->getId(), CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(409)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => false
            ])
        ;
    }

    public function testIsFeatureActivated403()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);

        $this->requestIsFeatureActivated($community->getId(), CollectionsFeature::getCode())
            ->execute()
            ->expectAuthError()
        ;
    }

    public function testIsFeatureActivated404()
    {
        $this->requestIsFeatureActivated(9999999, CollectionsFeature::getCode())
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(404)
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString()
            ])
        ;
    }

    public function testIsFeatureActivated200()
    {
        $community = SampleCommunitiesFixture::getCommunity(1);
        $communityId = $community->getId();

        $this->activateFeature($communityId, CollectionsFeature::getCode());
        $this->areFeaturesActivated($communityId, [
            CollectionsFeature::getCode() => true,
            BoardsFeature::getCode() => false,
            ChatFeature::getCode() => false
        ]);

        $this->activateFeature($communityId, ChatFeature::getCode());
        $this->areFeaturesActivated($communityId, [
            CollectionsFeature::getCode() => true,
            BoardsFeature::getCode() => false,
            ChatFeature::getCode() => true
        ]);

        $this->activateFeature($communityId, BoardsFeature::getCode());
        $this->areFeaturesActivated($communityId, [
            CollectionsFeature::getCode() => true,
            BoardsFeature::getCode() => true,
            ChatFeature::getCode() => true
        ]);

        $this->deactivateFeature($communityId, CollectionsFeature::getCode());
        $this->areFeaturesActivated($communityId, [
            CollectionsFeature::getCode() => false,
            BoardsFeature::getCode() => true,
            ChatFeature::getCode() => true
        ]);

        $this->deactivateFeature($communityId, BoardsFeature::getCode());
        $this->deactivateFeature($communityId, ChatFeature::getCode());
        $this->areFeaturesActivated($communityId, [
            CollectionsFeature::getCode() => false,
            BoardsFeature::getCode() => false,
            ChatFeature::getCode() => false
        ]);

        $this->activateFeature($communityId, CollectionsFeature::getCode());
        $this->activateFeature($communityId, BoardsFeature::getCode());
        $this->activateFeature($communityId, ChatFeature::getCode());
        $this->areFeaturesActivated($communityId, [
            CollectionsFeature::getCode() => true,
            BoardsFeature::getCode() => true,
            ChatFeature::getCode() => true
        ]);

        $this->deactivateFeature($communityId, CollectionsFeature::getCode());
        $this->deactivateFeature($communityId, BoardsFeature::getCode());
        $this->deactivateFeature($communityId, ChatFeature::getCode());
        $this->areFeaturesActivated($communityId, [
            CollectionsFeature::getCode() => false,
            BoardsFeature::getCode() => false,
            ChatFeature::getCode() => false
        ]);
    }

    private function areFeaturesActivated(int $communityId, array $features)
    {
        foreach($features as $code => $shouldBeActivated) {
            $this->requestIsFeatureActivated($communityId, $code)
                ->auth(DemoAccountFixture::getAccount()->getAPIKey())
                ->execute()
                ->expectStatusCode(200)
                ->expectJSONContentType()
                ->expectJSONBody([
                    'success' => true,
                    'is_feature_activated' => $shouldBeActivated
                ]);
        }
    }

    private function activateFeature(int $communityId, string $featureCode)
    {
        $this->requestActivateFeature($communityId, $featureCode)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;
    }

    private function deactivateFeature(int $communityId, string $featureCode)
    {
        $this->requestDeactivateFeature($communityId, $featureCode)
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ])
        ;
    }
}