<?php
namespace Domain\Index\Processor\ProcessorVariants;

use Domain\Collection\Entity\Collection;
use Domain\Feed\Factory\FeedSourceFactory;
use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Processor\Processor;
use Domain\Index\Service\ThemeWeightCalculator\ThemeWeightCalculator;
use Domain\Index\Source\Source;
use MongoDB\Database;

abstract class AbstractCollectionProcessor implements Processor
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
        /** @var \Domain\Collection\Entity\Collection $entity */
        $source = $this->getSource($entity);
        $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());

        $indexed = array_merge($entity->toIndexedEntityJSON(), [
            'theme_ids' => $this->getThemeIdsWeight($entity),
        ]);
        
        $collection->updateOne(
            ['id' => $entity->getId()],
            ['$set' => $indexed],
            ['upsert' => true]
        );
    }


    public function exclude(IndexedEntity $entity)
    {
        /** @var \Domain\Collection\Entity\Collection $entity */
        if($this->isIndexable($entity)) {
            $source = $this->getSource($entity);
            $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());

            $collection->deleteOne(['id' => $entity->getId()]);
        }
    }

    protected function getThemeIdsWeight(Collection $entity): array
    {
        return $this->themeWeightCalculator->calculate($entity);
    }

    abstract protected function getSource(Collection $entity): Source;
    abstract protected function isIndexable(Collection $entity): bool ;
}