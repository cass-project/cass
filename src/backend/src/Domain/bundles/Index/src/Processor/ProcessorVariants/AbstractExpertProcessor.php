<?php
namespace CASS\Domain\Bundles\Index\Processor\ProcessorVariants;

use CASS\Domain\Bundles\Feed\Factory\FeedSourceFactory;
use CASS\Domain\Bundles\Index\Entity\IndexedEntity;
use CASS\Domain\Bundles\Index\Processor\Processor;
use CASS\Domain\Bundles\Index\Service\ThemeWeightCalculator\ThemeWeightCalculator;
use CASS\Domain\Bundles\Index\Source\Source;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use MongoDB\Database;

abstract class AbstractExpertProcessor implements Processor
{
    /** @var Database */
    protected $mongoDB;

    /** @var FeedSourceFactory */
    protected $sourceFactory;

    /** @var ThemeWeightCalculator */
    protected $themeWeightCalculator;

    public function __construct(
        Database $mongoDB,
        FeedSourceFactory $sourceFactory,
        ThemeWeightCalculator $themeWeightCalculator
    ) {
        $this->mongoDB = $mongoDB;
        $this->sourceFactory = $sourceFactory;
        $this->themeWeightCalculator = $themeWeightCalculator;
    }

    public function process(IndexedEntity $entity)
    {
        /** @var Profile $entity */
        $source = $this->getSource($entity);
        $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());

        if(count($entity->getExpertInIds()) === 0) {
            $this->exclude($entity);
        }else{
            $indexed = array_merge($entity->toIndexedEntityJSON(), [
                'theme_ids' => $this->getThemeIdsWeight($entity),
            ]);

            $collection->updateOne(
                ['id' => $entity->getId()],
                ['$set' => $indexed],
                ['upsert' => true]
            );
        }
    }

    public function exclude(IndexedEntity $entity)
    {
        /** @var Profile $entity */
        if($this->isIndexable($entity)) {
            $source = $this->getSource($entity);
            $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());

            $collection->deleteOne(['id' => $entity->getId()]);
        }
    }

    protected function getThemeIdsWeight(Profile $entity): array
    {
        return $this->themeWeightCalculator->calculateWeights($entity->getExpertInIds());
    }

    abstract protected function getSource(Profile $entity): Source;
    abstract protected function isIndexable(Profile $entity): bool ;
}