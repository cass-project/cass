<?php
namespace Domain\Index\Source\Sources;

use Domain\Feed\Source\Source;

final class CollectionSource implements Source
{
    /** @var int */
    private $collectionId;

    public function __construct(int $collectionId)
    {
        $this->collectionId = $collectionId;
    }

    public function getMongoDBCollection(): string
    {
        return sprintf('collection_feed_%d', $this->collectionId);
    }
}