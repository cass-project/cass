<?php
namespace CASS\Domain\Bundles\Index\Processor\ProcessorVariants;

use CASS\Domain\Bundles\Feed\Factory\FeedSourceFactory;
use CASS\Domain\Bundles\Index\Entity\IndexedEntity;
use CASS\Domain\Bundles\Index\Processor\Processor;
use CASS\Domain\Bundles\Index\Service\ContentTypeIdentifier\ContentTypeIdentifier;
use CASS\Domain\Bundles\Index\Service\ThemeWeightCalculator\ThemeWeightCalculator;
use CASS\Domain\Bundles\Index\Source\Source;
use CASS\Domain\Bundles\Post\Entity\Post;
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
            $sources = $this->getSources($entity);

            array_map(function(Source $source) use ($entity) {
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
            }, $sources);
        }
    }

    public function exclude(IndexedEntity $entity)
    {
        /** @var Post $entity */
        if($this->isIndexable($entity)) {
            $sources = $this->getSources($entity);

            array_map(function(Source $source) use ($entity) {
                $collection = $this->mongoDB->selectCollection($source->getMongoDBCollection());

                $collection->deleteOne(['id' => $entity->getId()]);
            }, $sources);
        }
    }

    abstract protected function getSources(Post $entity): array;
    abstract protected function isIndexable(Post $entity): bool ;

    protected function getThemeIdsWeight(Post $entity): array
    {
        return $this->themeWeightCalculator->calculateWeights($entity->getThemeIds());
    }

    protected function getContentType(Post $entity): string
    {
        return $this->contentTypeIdentifier->detectContentTypeOfPost($entity);
    }
}