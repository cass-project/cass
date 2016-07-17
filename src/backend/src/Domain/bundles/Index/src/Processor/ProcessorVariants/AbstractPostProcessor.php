<?php
namespace Domain\Index\Processor\ProcessorVariants;

use Domain\Feed\Factory\FeedSourceFactory;
use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Processor\Processor;
use Domain\Index\Service\ContentTypeIdentifier\ContentTypeIdentifier;
use Domain\Index\Service\ThemeWeightCalculator\ThemeWeightCalculator;
use Domain\Index\Source\Source;
use Domain\Post\Entity\Post;
use MongoDB\Database;

abstract class AbstractPostProcessor implements Processor
{
    /** @var Database */
    protected $mongoDB;

    /** @var FeedSourceFactory */
    protected $sourceFactory;

    /** @var ThemeWeightCalculator */
    protected $themeWeightCalculator;

    /** @var ContentTypeIdentifier */
    protected $contentTypeIdentifier;

    public function __construct(
        Database $mongoDB,
        FeedSourceFactory $sourceFactory,
        ThemeWeightCalculator $themeWeightCalculator,
        ContentTypeIdentifier $contentTypeIdentifier
    ) {
        $this->mongoDB = $mongoDB;
        $this->sourceFactory = $sourceFactory;
        $this->themeWeightCalculator = $themeWeightCalculator;
        $this->contentTypeIdentifier = $contentTypeIdentifier;
    }

    public function process(IndexedEntity $entity)
    {
        /** @var Post $entity */
        if($this->isIndexable($entity)) {
            $source = $this->getSource($entity);
            $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());

            $indexed = array_merge($entity->toIndexedEntityJSON(), [
                'theme_ids' => $this->getThemeIdsWeight($entity),
                'content_type' => $this->getContentType($entity),
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
        /** @var Post $entity */
        if($this->isIndexable($entity)) {
            $source = $this->getSource($entity);
            $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());

            $collection->deleteOne(['id' => $entity->getId()]);
        }
    }

    abstract protected function getSource(Post $entity): Source;
    abstract protected function isIndexable(Post $entity): bool ;

    protected function getThemeIdsWeight(Post $entity): array
    {
        return $this->themeWeightCalculator->calculate($entity);
    }

    protected function getContentType(Post $entity): string
    {
        return $this->contentTypeIdentifier->detectContentTypeOfPost($entity);
    }
}