<?php
namespace Domain\Index\Processor\ProcessorVariants;

use Domain\Community\Entity\Community;
use Domain\Feed\Factory\FeedSourceFactory;
use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Processor\Processor;
use Domain\Index\Service\ThemeWeightCalculator\ThemeWeightCalculator;
use Domain\Index\Source\Source;
use Domain\Post\Entity\Post;
use MongoDB\Database;

abstract class AbstractCommunityProcessor implements Processor
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
        /** @var Community $entity */
        if($this->isIndexable($entity)) {
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
    }

    public function exclude(IndexedEntity $entity)
    {
        /** @var Community $entity */
        if($this->isIndexable($entity)) {
            $source = $this->getSource($entity);
            $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());

            $collection->deleteOne(['id' => $entity->getId()]);
        }
    }

    abstract protected function getSource(Community $entity): Source;
    abstract protected function isIndexable(Community $entity): bool ;

    protected function getThemeIdsWeight(Community $entity): array
    {
        return $this->themeWeightCalculator->calculate($entity);
    }
}