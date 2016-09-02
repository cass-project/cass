<?php
namespace CASS\Domain\Bundles\Community\Feature;

use DI\Container;
use CASS\Domain\Bundles\Community\Exception\UnknownFeatureException;
use CASS\Domain\Bundles\Community\Feature\Features\BoardsFeature;
use CASS\Domain\Bundles\Community\Feature\Features\ChatFeature;
use CASS\Domain\Bundles\Community\Feature\Features\CollectionsFeature;

class FeaturesFactory
{
    /** @var Container */
    private $container;

    /** @var array */
    private $FEATURES = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->FEATURES = [
            CollectionsFeature::getCode() => CollectionsFeature::class,
            BoardsFeature::getCode() => BoardsFeature::class,
            ChatFeature::getCode() => ChatFeature::class,
        ];
    }

    public function listFeatures(): array
    {
        return array_values($this->FEATURES);
    }

    public function each(Callable $fn) {
        foreach($this->listFeatures() as $feature) {
            $fn($this->createFeatureFromClassName($feature));
        }
    }

    public function listFeatureCodes(): array
    {
        return array_keys($this->FEATURES);
    }

    public function getFeatureClassNameFromStringCode(string $featureCode): string
    {
        if(! in_array($featureCode, $this->listFeatureCodes())) {
            throw new UnknownFeatureException(sprintf('Unknown feature `%s`', $featureCode));
        }

        return $this->FEATURES[$featureCode];
    }

    public function createFeatureFromStringCode(string $featureCode): Feature
    {
        if(! in_array($featureCode, $this->listFeatureCodes())) {
            throw new UnknownFeatureException(sprintf('Unknown feature `%s`', $featureCode));
        }

        return $this->container->get($this->getFeatureClassNameFromStringCode($featureCode));
    }

    public function createFeatureFromClassName(string $featureClassName): Feature
    {
        if(! in_array($featureClassName, $this->listFeatures())) {
            throw new UnknownFeatureException(sprintf('Unknown feature class `%s`', $featureClassName));
        }

        return $this->container->get($featureClassName);
    }
}