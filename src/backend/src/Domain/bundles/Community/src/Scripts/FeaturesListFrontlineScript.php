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

    public function __invoke(): array
    {
        return $this->featuresFactory->listFeatures();
    }
}