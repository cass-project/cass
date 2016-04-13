<?php
namespace Collection\Service\Parameters\CollectionService;

class CollectionDeleteParameters
{
    /** @var int */
    private $collectionId;

    public function __construct(int $collectionId)
    {
        $this->collectionId = $collectionId;
    }

    public function getCollectionId(): int
    {
        return $this->collectionId;
    }
}