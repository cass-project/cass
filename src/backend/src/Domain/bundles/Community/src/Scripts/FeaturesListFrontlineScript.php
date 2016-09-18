<?php
namespace CASS\Domain\Bundles\Community\Scripts;

use CASS\Application\Bundles\Frontline\FrontlineScript;
use CASS\Domain\Bundles\Community\Feature\FeaturesFactory;

class FeaturesListFrontlineScript implements FrontlineScript
{
    /** @var FeaturesFactory */
    private $featuresFactory;

    public function __construct(FeaturesFactory $featuresFactory)
    {
        $this->featuresFactory = $featuresFactory;
    }

    public function tags(): array {
        return [
            FrontlineScript::TAG_GLOBAL
        ];
    }

    public function __invoke(): array
    {
        return [
            'config' => [
                'community' => [
                    'features' => array_map(function($className) {
                        $feature = $this->featuresFactory->createFeatureFromClassName($className);

                        return [
                            'code' => $feature->getCode(),
                            'name' => $feature->getTranslatedName(),
                            'description' => $feature->getTranslatedDescription(),
                            'fa_icon' => $feature->getFACode(),
                            'is_development_ready' => $feature->isDevelopmentReady(),
                            'is_production_ready' => $feature->isProductionReady(),
                        ];
                    }, $this->featuresFactory->listFeatures())
                ]
            ]
        ];
    }
}