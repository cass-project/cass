<?php
namespace CASS\Domain\Index\Processor\ProcessorVariants;

use CASS\Domain\Collection\Entity\Collection;
use CASS\Domain\Feed\Factory\FeedSourceFactory;
use CASS\Domain\Index\Entity\IndexedEntity;
use CASS\Domain\Index\Processor\Processor;
use CASS\Domain\Index\Service\ThemeWeightCalculator\ThemeWeightCalculator;
use CASS\Domain\Index\Source\Source;
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
        /** @var \CASS\Domain\Collection\Entity\Collection $entity */
        $source = $this->getSource($entity);
        $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());

        if(count($entity->getThemeIds()) > 0) {
            $indexed = array_merge($entity->toIndexedEntityJSON(), [
                'theme_ids' => $this->getThemeIdsWeight($entity),
            ]);

            $collection->updateOne(
                ['id' => $entity->getId()],
                ['$set' => $indexed],
                ['upsert' => true]
            );
        }else{
            $this->exclude($entity);
        }
    }


    public function exclude(IndexedEntity $entity)
    {
        /** @var \CASS\Domain\Collection\Entity\Collection $entity */
        if($this->isIndexable($entity)) {
            $source = $this->getSource($entity);
            $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());

            $collection->deleteOne(['id' => $entity->getId()]);
        }
    }

    protected function getThemeIdsWeight(Collection $entity): array
    {
        return $this->themeWeightCalculator->calculateWeights($entity->getThemeIds());
    }

    abstract protected function getSource(Collection $entity): Source;
    abstract protected function isIndexable(Collection $entity): bool ;
}