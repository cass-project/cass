<?php
namespace Domain\Community\Scripts;

use Application\Frontline\FrontlineScript;
use Domain\Community\Feature\FeaturesFactory;

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
                            'is_development_ready' => $feature->isDevelopmentReady(),
                            'is_production_ready' => $feature->isProductionReady(),
                        ];
                    }, $this->featuresFactory->listFeatures())
                ]
            ]
        ];
    }
}