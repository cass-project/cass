<?php
namespace Domain\Index\Processor\ProcessorVariants;

use Domain\Feed\Factory\FeedSourceFactory;
use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Processor\Processor;
use Domain\Index\Service\ThemeWeightCalculator\ThemeWeightCalculator;
use Domain\Index\Source\Source;
use Domain\Profile\Entity\Profile;
use MongoDB\Database;

abstract class AbstractProfileProcessor implements Processor
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

        if(count($entity->getInterestingInIds()) === 0) {
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
        return $this->themeWeightCalculator->calculateProfileInterestsWeight($entity);
    }

    abstract protected function getSource(Profile $entity): Source;
    abstract protected function isIndexable(Profile $entity): bool ;
}